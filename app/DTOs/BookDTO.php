<?php

namespace App\DTOs;

class BookDTO
{
    public function __construct(
        public readonly string $title,
        public readonly int $publisher_id,
        public readonly int $theme_id,
        public readonly string $isbn,
        public readonly array $authors,
        public readonly ?string $subtitle = null,
        public readonly ?int $publication_year = null,
        public readonly ?int $quantity = 1,
        public readonly ?int $number_of_pages = null,
        public readonly ?string $cutter_code = null,
        public readonly ?string $description = null,
    ) {}
}