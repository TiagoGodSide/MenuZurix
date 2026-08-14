<?php

namespace App\Services;

use App\Dto\PublicCategoryDto;
use App\Dto\PublicMenuDto;
use App\Dto\PublicOptionGroupDto;
use App\Dto\PublicOptionItemDto;
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
                                    ->with([
                                        'primaryImage',

                                        'optionGroups' => function ($query) {
                                            $query
                                                ->active()
                                                ->orderByPivot('sort_order')
                                                ->with([
                                                    'items' => function ($query) {
                                                        $query
                                                            ->active()
                                                            ->orderBy('sort_order')
                                                            ->orderBy('name');
                                                    },
                                                ]);
                                        },
                                    ]);
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

                                id: $product->id,

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

                                optionGroups: $product->optionGroups
                                    ->map(
                                        fn ($group) => new PublicOptionGroupDto(

                                            uuid: $group->uuid,

                                            name: $group->name,

                                            description: $group->description,

                                            selectionType: $group->selection_type,

                                            minChoices: (int) $group->pivot->min_choices,

                                            maxChoices: (int) $group->pivot->max_choices,

                                            items: $group->items
                                            ->where('is_active', true)
                                                ->map(
                                                    fn ($item) => new PublicOptionItemDto(

                                                        uuid: $item->uuid,

                                                        name: $item->name,

                                                        description: $item->description,

                                                        additionalPrice: (float) $item->additional_price,

                                                        maxQuantity: (int) $item->max_quantity,

                                                        isDefault: (bool) $item->is_default,
                                                    )
                                                )
                                                ->values()
                                                ->toArray(),
                                        )
                                    )->values()
                                    ->toArray(),
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