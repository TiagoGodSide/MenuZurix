<?php

namespace App\Dto;

class PublicOptionGroupDto
{
    public function __construct(
        public readonly string $uuid,

        public readonly string $name,

        public readonly ?string $description,

        public readonly string $selectionType,

        public readonly int $minChoices,

        public readonly int $maxChoices,

        /** @var PublicOptionItemDto[] */
        public readonly array $items,
    ) {
    }
}