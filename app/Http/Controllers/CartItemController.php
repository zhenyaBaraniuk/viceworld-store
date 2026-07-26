<?php

namespace App\Http\Controllers;

use App\Data\Cart\CartData;
use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function store(AddCartItemRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $cart = $this->cartService->getOrCreateCart(
            $request->user('customer'),
            $request->cookie('cart_token')
        );

        $this->cartService->addItem(
            $cart,
            $validatedData['product_variant_id'],
            $validatedData['quantity']
        );

        $cart = $this->cartService->getCartWithRelations($cart);

        return response()->json(CartData::fromModel($cart));
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): JsonResponse
    {
        $this->cartService->updateItemQuantity(
            $cartItem,
            $request->validated('quantity'),
        );

        $cart = $this->cartService->getCartWithRelations($cartItem->cart_id);

        return response()->json(CartData::fromModel($cart));
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        $this->cartService->removeItem($cartItem);

        $cart = $this->cartService->getCartWithRelations($cartItem->cart_id);

        return response()->json(CartData::fromModel($cart));
    }
}
