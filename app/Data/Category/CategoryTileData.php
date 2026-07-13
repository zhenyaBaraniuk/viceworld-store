<?php

namespace App\Data\Category;

use App\Models\Category;
use Spatie\LaravelData\Data;

class CategoryTileData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $image_url,
    ) {}

    public static function fromModel(Category $category): self
    {
        $mainImage = $category->mediaFiles()
            ->wherePivot('collection', 'main_image')
            ->first()?->url;

        return new self(
            name: $category->name,
            slug: $category->slug,
            image_url: $mainImage,
        );
    }
}
