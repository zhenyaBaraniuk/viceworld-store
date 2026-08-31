<?php

namespace App\Data\Cart;

use App\Data\AttributeValue\AttributeValueData;
use App\Models\CartItem;
use App\Models\Media;
use Spatie\LaravelData\Data;

class CartItemData extends Data
{
    public function __construct(
        public string $id,
        public int $quantity,
        public string $product_name,
        public string $product_slug,
        public ?array $image,
        public string $price,
        /** @var AttributeValueData[] */
        public array $attribute_values,
    ) {}

    public static function fromModel(CartItem $item): self
    {
        $product = $item->productVariant->product;
        $mainImage = $product->mediaFiles()->wherePivot('collection', 'main_image')->first();

        return new self(
            $item->id,
            $item->quantity,
            $product->name,
            $product->slug,
            $mainImage ? self::mapMedia($mainImage) : null,
            $product->price,
            $item->productVariant->attributeValues
                ->map(fn ($attributeValue) => AttributeValueData::fromModel($attributeValue))
                ->all(),
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
