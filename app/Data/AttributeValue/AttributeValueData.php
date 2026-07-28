<?php

namespace App\Data\AttributeValue;

use App\Models\AttributeValue;
use Spatie\LaravelData\Data;

class AttributeValueData extends Data
{
    public function __construct(
        public string $name,
        public string $value,
        public ?string $hex,
    ) {}

    public static function fromModel(AttributeValue $attributeValue): self
    {
        return new self(
            $attributeValue->attribute->name,
            $attributeValue->value,
            $attributeValue->color,
        );
    }
}
