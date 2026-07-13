<?php

namespace App\Data\Category;

use Spatie\LaravelData\Data;

class CategoryData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $slug,
    ) {}
}
