<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Checkout/index', [
            'payment_methods' => config('payment.methods'),
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $cart = $this->cartService->getOrCreateCart(
            $request->user('customer'),
            $request->cookie('cart_token'),
        );

        $customer = $request->user('customer');

        $cart->load('cartItems.productVariant.product');

        $this->orderService->createOrder($cart, $data, $customer);

        $this->cartService->clearCart($cart);

        return to_route('success-order');
    }
}
