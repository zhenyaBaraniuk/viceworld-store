<?php

namespace App\Data\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Spatie\LaravelData\Data;

class CartData extends Data
{
    public function __construct(
        public ?string $customer_id,
        public ?string $session_id,
        public float $total_price,
        /** @var CartItemData[] */
        public array $cart_items,
    ) {}

    public static function fromModel(Cart $cart): self
    {
        return new self(
            $cart->customer_id,
            $cart->session_token,
            $cart->getTotalPrice(),
            $cart->cartItems->map(fn (CartItem $cartItem) => CartItemData::fromModel($cartItem))->all(),
        );
    }
}
