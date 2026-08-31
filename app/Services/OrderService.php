<?php

namespace App\Services;

use App\Enums\Currency;
use App\Enums\Order\DeliveryMethod;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentStatus;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(Cart $cart, array $data, ?Customer $customer): Order
    {
        return DB::transaction(function () use ($cart, $data, $customer) {
            $totalAmount = $cart->getTotalPrice();

            $payment = Payment::query()->create([
                'provider' => $data['payment_method'],
                'amount' => $totalAmount,
                'currency' => Currency::UAH,
                'status' => PaymentStatus::PENDING,
            ]);

            $order = Order::query()->create([
                'customer_id' => $customer?->id,
                'payment_id' => $payment->id,
                'cart_id' => $cart->id,
                'status' => OrderStatus::PENDING,
                'delivery_method' => $data['delivery_method'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'total_amount' => $totalAmount,
                'shipping_address' => $data['delivery_method'] === DeliveryMethod::COURIER->value
                    ? ['city' => $data['city'], 'street' => $data['street']]
                    : ['address' => 'Kyiv, Baseina 12'],
            ]);

            foreach ($cart->cartItems as $cartItem) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_variant_id' => $cartItem->productVariant->id,
                    'product_name' => $cartItem->productVariant->product->name,
                    'sku' => $cartItem->productVariant->sku,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->productVariant->product->price,
                ]);
            }

            return $order;
        });
    }
}
