<?php

namespace App\Services;

use App\Dto\PublicCategoryDto;
use App\Dto\PublicMenuDto;
use App\Dto\PublicProductDto;
use App\Dto\PublicProductImageDto;
use App\Models\Business;

class PublicMenuService
{
    public function findBySlug(string $slug): PublicMenuDto
    {
        $business = Business::query()
            ->where('slug', $slug)
            ->with([
                'categories' => function ($query) {
                    $query
                        ->active()
                        ->ordered()
                        ->with([
                            'products' => function ($query) {
                                $query
                                    ->available()
                                    ->ordered()
                                    ->with('primaryImage');
                            },
                        ]);
                },
            ])
            ->firstOrFail();


       $categories = $business->categories
    ->map(
        fn ($category) => new PublicCategoryDto(
            name: $category->name,

            products: $category->products
                ->map(
                    fn ($product) => new PublicProductDto(
                        name: $product->name,

                        shortDescription: $product->short_description,

                        price: (float) $product->price,

                        promotionalPrice: $product->promotional_price
                            ? (float) $product->promotional_price
                            : null,

                        preparationTime: $product->preparation_time,

                        isFeatured: $product->is_featured,

                        isProductOfTheDay: $product->is_product_of_the_day,

                        isAvailable: $product->is_available,

                        image: $product->primaryImage
                            ? new PublicProductImageDto(
                                path: $product->primaryImage->image_path
                            )
                            : null,
                    )
                )
                ->toArray()
        )
    )
    ->toArray();
    

        return new PublicMenuDto(
    name: $business->name,
    logo: $business->logo_path,
    banner: $business->banner_path,
    isOpen: $business->isOpen(),
    categories: $categories,
);
    }
}