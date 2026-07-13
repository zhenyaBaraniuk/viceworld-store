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
        public ?string $main_image,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            name: $product->name,
            slug: $product->slug,
            price: $product->price,
            main_image: $product->getFirstMediaUrl('main_image'),
        );
    }
}
