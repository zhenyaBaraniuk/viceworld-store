<?php

namespace App\Data\Product;

use App\Models\Product;
use Spatie\LaravelData\Data;

class ProductListData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $price,
        public ?string $main_image_url,
        public string $category_name,
    ) {}

    public static function fromModel(Product $product): self
    {
        $mainImageUrl = $product->mediaFiles()
            ->wherePivot('collection', 'main_image')
            ->first()?->url;

        return new self(
            name: $product->name,
            slug: $product->slug,
            price: $product->price,
            main_image_url: $mainImageUrl,
            category_name: $product->category->name,
        );
    }
}
