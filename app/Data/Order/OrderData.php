<?php

namespace App\Data\Order;

use App\Models\Media;
use App\Models\Order;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public string $id,
        public string $status,
        public string $total_amount,
        public string $created_at,
        public ?array $image,
        public int $items_count,
    ) {}

    public static function fromModel(Order $order): self
    {
        $product = $order->orderItems
            ->sortByDesc('price')
            ->first()
            ?->productVariant
            ?->product;

        $mainImage = $product?->mediaFiles
            ->first(fn (Media $media) => $media->pivot->collection === 'main_image');

        return new self(
            id: $order->id,
            status: $order->status->value,
            total_amount: $order->total_amount,
            created_at: $order->created_at->toIso8601String(),
            image: $mainImage ? self::mapMedia($mainImage) : null,
            items_count: $order->order_items_count,
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
