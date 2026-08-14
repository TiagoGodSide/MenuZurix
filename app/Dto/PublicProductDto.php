<?php

namespace App\Dto;

class PublicProductDto
{
    public function __construct(

        public readonly int $id,

        public readonly string $name,

        public readonly ?string $shortDescription,

        public readonly float $price,

        public readonly ?float $promotionalPrice,

        public readonly ?int $preparationTime,

        public readonly bool $isFeatured,

        public readonly bool $isProductOfTheDay,

        public readonly bool $isAvailable,

        public readonly ?PublicProductImageDto $image,

        public readonly array $optionGroups = [],
    ) {
    }

    public function hasPromotion(): bool
    {
        return $this->promotionalPrice !== null
            && (float) $this->promotionalPrice < (float) $this->price;
    }
}