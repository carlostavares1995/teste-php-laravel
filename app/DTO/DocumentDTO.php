<?php

namespace App\DTO;

class DocumentDTO
{
    public function __construct(
        public ?string $category,
        public ?string $title,
        public ?string $contents
    ) {
    }
}
