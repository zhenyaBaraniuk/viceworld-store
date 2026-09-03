<?php

namespace App\Data\Product;

use App\Models\Product;
use Spatie\LaravelData\Data;

class ProductShortData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $price,
        public ?string $main_image_url,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            $product->name,
            $product->slug,
            $product->price,
            $product->mediaFiles()->wherePivot('collection', 'main_image')->first()?->url,
        );
    }
}
