<?php

namespace App\Data\ProductVariant;

use App\Models\ProductVariant;
use Spatie\LaravelData\Data;

class ProductVariantData extends Data
{
    public function __construct(
        public string $id,
        public ?string $price,
        public bool $is_active,
        public array $attribute_values,
    ) {}

    public static function fromModel(ProductVariant $variant): self
    {
        return new self(
            id: $variant->id,
            price: $variant->price,
            is_active: $variant->is_active,
            attribute_values: $variant->attributeValues
                ->map(fn ($attributeValue) => [
                    'name' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                    'hex' => $attributeValue->color,
                ])->toArray(),
        );
    }
}
