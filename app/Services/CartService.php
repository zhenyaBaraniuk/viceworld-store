<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;

class CartService
{
    public const EAGER_LOAD = [
        'cartItems.productVariant.attributeValues',
        'cartItems.productVariant.product.mediaFiles',
    ];

    public function getOrCreateCart(?Customer $customer, ?string $sessionToken = null): Cart
    {
        if ($customer) {
            return Cart::with(self::EAGER_LOAD)->firstOrCreate([
                'customer_id' => $customer->id,
            ]);
        }

        return Cart::with(self::EAGER_LOAD)->firstOrCreate(['session_token' => $sessionToken]);
    }

    public function addItem(Cart $cart, string $productVariantId, int $quantity): CartItem
    {
        $item = $cart->cartItems()->where(
            'product_variant_id', '=', $productVariantId
        )->first();

        if ($item) {
            $item->increment('quantity', $quantity);

            return $item;
        }

        return $cart->cartItems()->create([
            'product_variant_id' => $productVariantId,
            'quantity' => $quantity,
        ]);
    }

    public function updateItemQuantity(CartItem $cartItem, int $quantity): CartItem
    {
        $cartItem->update(['quantity' => $quantity]);

        return $cartItem;
    }

    public function removeItem(CartItem $cartItem): void
    {
        $cartItem->delete();
    }

    public function clearCart(Cart $cart): void
    {
        $cart->cartItems()->delete();
    }

    public function getCartWithRelations(string $cartId): Cart
    {
        return Cart::with(self::EAGER_LOAD)->findOrFail($cartId);
    }
}
