<?php

namespace App\Dto;

class PublicProductImageDto
{
    public function __construct(
        public readonly string $path,
    ) {
    }
}