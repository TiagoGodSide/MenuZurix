<?php

namespace App\Dto;

class PublicOptionItemDto
{
    public function __construct(
        public readonly string $uuid,

        public readonly string $name,

        public readonly ?string $description,

        public readonly float $additionalPrice,

        public readonly int $maxQuantity,

        public readonly bool $isDefault,
    ) {
    }
}