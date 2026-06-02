<?php

namespace App\Data\Product;

use App\Data\ProductVariant\ProductVariantData;
use Spatie\LaravelData\Data;
use App\Models\Product;

class ProductData extends Data
{
    public function __construct(
        public string  $name,
        public string  $slug,
        public string  $price,
        public ?string $description,
        public ?string $main_image,
        /** @var string[] */
        public array   $images,
        /** @var array<ProductVariantData> */
        public array   $product_variants,
    )
    {
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            name: $product->name,
            slug: $product->slug,
            price: $product->price,
            description: $product->description,
            main_image: $product->getFirstMediaUrl('main_image'),
            images: $product->getMedia('images')
                ->map(fn($media) => $media->getUrl())
                ->toArray(),
            product_variants: $product->productVariants
                ->map(fn($productVariant) => ProductVariantData::fromModel($productVariant))
                ->values()
                ->all()
        );
    }
}
