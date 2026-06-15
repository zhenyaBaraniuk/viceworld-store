<?php

namespace App\Data\Product;

use App\Data\ProductVariant\ProductVariantData;
use App\Models\Media;
use App\Models\Product;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $price,
        public ?array $description,
        public ?array $main_image,
        public ?array $video,
        /** @var string[] */
        public array $images,
        /** @var array<ProductVariantData> */
        public array $product_variants,
    ) {}

    public static function fromModel(Product $product): self
    {
        $mainImage = $product->mediaFiles()->wherePivot('collection', 'main_image')->first();
        $video = $product->mediaFiles()->wherePivot('collection', 'video')->first();
        $images = $product->mediaFiles()->wherePivot('collection', 'images')->orderByPivot('order')->get();

        return new self(
            name: $product->name,
            slug: $product->slug,
            price: $product->price,
            description: $product->description,
            main_image: $mainImage ? self::mapMedia($mainImage) : null,
            video: $video ? self::mapMedia($video) : null,
            images: $images->map(fn ($media) => self::mapMedia($media))->toArray(),
            product_variants: $product->productVariants
                ->map(fn ($productVariant) => ProductVariantData::fromModel($productVariant))
                ->values()
                ->all()
        );
    }

    private static function mapMedia(Media $media): array
    {
        return [
            'id' => $media->id,
            'url' => $media->url,
            'mime_type' => $media->mime_type,
        ];
    }
}
