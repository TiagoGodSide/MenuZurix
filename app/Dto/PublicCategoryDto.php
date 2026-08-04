<?php

namespace App\Dto;

class PublicCategoryDto
{
    public function __construct(
        public readonly string $name,
        /** @var PublicProductDto[] */
        public readonly array $products,
    ) {
    }
}