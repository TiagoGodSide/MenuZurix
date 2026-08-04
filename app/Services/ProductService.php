<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProductService
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {
    }

    /**
     * @param array<int, UploadedFile> $images
     *
     * @throws Throwable
     */
    public function create(
        Business $business,
        array $data,
        array $images = []
    ): Product {
        $storedPaths = [];

        try {
            $product = DB::transaction(function () use (
                $business,
                $data,
                $images,
                &$storedPaths
            ): Product {
                $data['business_id'] = $business->id;
                $data['slug'] = $this->generateUniqueSlug(
                    $business,
                    $data['name']
                );

                $product = Product::create($data);

                foreach ($images as $index => $image) {
                    $path = $this->fileUploadService->storeImage(
                        $image,
                        'products/'.$business->uuid.'/'.$product->uuid
                    );

                    $storedPaths[] = $path;

                    $product->images()->create([
                        'image_path' => $path,
                        'alt_text' => $product->name,
                        'sort_order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }

                return $product->load([
                    'category',
                    'images',
                ]);
            });
        } catch (Throwable $exception) {
            foreach ($storedPaths as $path) {
                $this->fileUploadService->delete($path);
            }

            throw $exception;
        }

        return $product;
    }

    /**
     * @param array<int, UploadedFile> $images
     *
     * @throws Throwable
     */
    public function update(
        Product $product,
        array $data,
        array $images = []
    ): Product {
        $storedPaths = [];

        try {
            $product = DB::transaction(function () use (
                $product,
                $data,
                $images,
                &$storedPaths
            ): Product {
                if ($product->name !== $data['name']) {
                    $data['slug'] = $this->generateUniqueSlug(
                        $product->business,
                        $data['name'],
                        $product
                    );
                }

                $product->update($data);

                $nextOrder = (int) $product->images()
                    ->max('sort_order') + 1;

                $hasPrimaryImage = $product->images()
                    ->where('is_primary', true)
                    ->exists();

                foreach ($images as $index => $image) {
                    $path = $this->fileUploadService->storeImage(
                        $image,
                        'products/'.
                            $product->business->uuid.
                            '/'.
                            $product->uuid
                    );

                    $storedPaths[] = $path;

                    $product->images()->create([
                        'image_path' => $path,
                        'alt_text' => $product->name,
                        'sort_order' => $nextOrder + $index,
                        'is_primary' => ! $hasPrimaryImage && $index === 0,
                    ]);
                }

                return $product->refresh()->load([
                    'category',
                    'images',
                ]);
            });
        } catch (Throwable $exception) {
            foreach ($storedPaths as $path) {
                $this->fileUploadService->delete($path);
            }

            throw $exception;
        }

        return $product;
    }

    /**
     * Exclusão lógica do produto.
     */
    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function toggleStatus(Product $product): Product
    {
        $product->update([
            'is_active' => ! $product->is_active,
        ]);

        return $product->refresh();
    }

    public function toggleAvailability(Product $product): Product
    {
        $product->update([
            'is_available' => ! $product->is_available,
        ]);

        return $product->refresh();
    }

    public function toggleSoldOut(Product $product): Product
    {
        $product->update([
            'is_sold_out' => ! $product->is_sold_out,
        ]);

        return $product->refresh();
    }

    /**
     * @throws Throwable
     */
    public function duplicate(Product $product): Product
    {
        return DB::transaction(function () use ($product): Product {
            $copy = $product->replicate([
                'uuid',
                'slug',
                'sku',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);

            $copy->name = $product->name.' - Cópia';

            $copy->slug = $this->generateUniqueSlug(
                $product->business,
                $copy->name
            );

            $copy->sku = null;
            $copy->is_active = false;
            $copy->is_available = false;
            $copy->is_sold_out = false;

            $copy->save();

            foreach ($product->optionGroups as $group) {
                $copy->optionGroups()->attach(
                    $group->id,
                    [
                        'min_choices' => $group->pivot->min_choices,
                        'max_choices' => $group->pivot->max_choices,
                        'sort_order' => $group->pivot->sort_order,
                    ]
                );
            }

            return $copy->load([
                'category',
                'optionGroups',
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function deleteImage(
        Product $product,
        ProductImage $image
    ): void {
        abort_unless(
            $image->product_id === $product->id,
            404
        );

        $path = $image->image_path;
        $wasPrimary = $image->is_primary;

        DB::transaction(function () use (
            $product,
            $image,
            $wasPrimary
        ): void {
            $image->delete();

            if ($wasPrimary) {
                $newPrimary = $product->images()
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->first();

                $newPrimary?->update([
                    'is_primary' => true,
                ]);
            }
        });

        $this->fileUploadService->delete($path);
    }

    public function setPrimaryImage(
        Product $product,
        ProductImage $image
    ): void {
        abort_unless(
            $image->product_id === $product->id,
            404
        );

        DB::transaction(function () use (
            $product,
            $image
        ): void {
            $product->images()->update([
                'is_primary' => false,
            ]);

            $image->update([
                'is_primary' => true,
            ]);
        });
    }

    private function generateUniqueSlug(
        Business $business,
        string $name,
        ?Product $ignoreProduct = null
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'produto';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Product::withTrashed()
                ->where('business_id', $business->id)
                ->when(
                    $ignoreProduct !== null,
                    fn ($query) => $query->whereKeyNot(
                        $ignoreProduct->getKey()
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}