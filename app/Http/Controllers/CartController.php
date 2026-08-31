<?php

namespace App\Http\Controllers;

use App\Data\Cart\CartData;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart(
            $request->user('customer'),
            $request->cookie('cart_token')
        );

        return response()->json(CartData::fromModel($cart));
    }

    public function destroy(Request $request): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart(
            $request->user('customer'),
            $request->cookie('cart_token')
        );

        $this->cartService->clearCart($cart);

        return response()->json(CartData::fromModel($cart->fresh()->load(CartService::EAGER_LOAD)));
    }
}
