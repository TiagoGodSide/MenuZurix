<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CategoryService
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function create(
        array $data,
        ?UploadedFile $bannerImage = null
    ): Category {
        return DB::transaction(function () use (
            $data,
            $bannerImage
        ): Category {
            $data['slug'] = $this->generateUniqueSlug(
                $data['name']
            );

            if ($bannerImage !== null) {
                $data['banner_image'] = $this->fileUploadService->storeImage(
                    $bannerImage,
                    'categories/banners'
                );
            }

            return Category::create($data);
        });
    }

    /**
     * @throws Throwable
     */
    public function update(
        Category $category,
        array $data,
        ?UploadedFile $bannerImage = null
    ): Category {
        return DB::transaction(function () use (
            $category,
            $data,
            $bannerImage
        ): Category {
            if ($category->name !== $data['name']) {
                $data['slug'] = $this->generateUniqueSlug(
                    $data['name'],
                    $category
                );
            }

            if ($bannerImage !== null) {
                $newImagePath = $this->fileUploadService->storeImage(
                    $bannerImage,
                    'categories/banners'
                );

                $oldImagePath = $category->banner_image;

                $data['banner_image'] = $newImagePath;

                $category->update($data);

                if ($oldImagePath !== null) {
                    Storage::disk('public')->delete(
                        $oldImagePath
                    );
                }

                return $category->refresh();
            }

            $category->update($data);

            return $category->refresh();
        });
    }

    /**
     * @throws Throwable
     */
    public function delete(Category $category): void
    {
        DB::transaction(function () use ($category): void {
            $bannerImage = $category->banner_image;

            $category->delete();

            if ($bannerImage !== null) {
                Storage::disk('public')->delete(
                    $bannerImage
                );
            }
        });
    }

    public function toggleStatus(Category $category): Category
    {
        $category->update([
            'is_active' => ! $category->is_active,
        ]);

        return $category->refresh();
    }

    private function generateUniqueSlug(
        string $name,
        ?Category $ignoreCategory = null
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'categoria';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            Category::query()
                ->when(
                    $ignoreCategory !== null,
                    fn ($query) => $query->whereKeyNot(
                        $ignoreCategory->getKey()
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