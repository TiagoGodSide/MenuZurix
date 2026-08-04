<?php

namespace App\Dto;

class PublicMenuDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $logo,
        public readonly ?string $banner,
        public readonly bool $isOpen,

        /** @var PublicCategoryDto[] */
        public readonly array $categories,
    ) {
    }
}