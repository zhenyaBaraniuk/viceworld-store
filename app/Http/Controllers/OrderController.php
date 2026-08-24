<?php

namespace App\Http\Controllers;

use App\Enums\Payment\PaymentProvider;
use App\Http\Requests\StoreOrderRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Payment\PaymentManager;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
        private readonly PaymentManager $paymentManager,
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

        $order = $this->orderService->createOrder($cart, $data, $customer);

        $provider = PaymentProvider::from($data['payment_method']);
        $url = $this->paymentManager->provider($provider)->createPayment($order->payment);

        return Inertia::location($url);
    }
}
