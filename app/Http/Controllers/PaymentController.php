<?php

namespace App\Http\Controllers;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Requests\CreatePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use PaymentManager;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentManager $paymentManager) {}

    public function store(CreatePaymentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $payment = Payment::create([
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'provider' => $data['provider'],
            'description' => $data['description'] ?? null,
            'status' => PaymentStatus::PENDING,
        ]);

        $provider = PaymentProvider::from($data['provider']);

        $checkoutUrl = $this->paymentManager->provider($provider)->createPayment($payment);

        return response()->json([
            'payment_id' => $payment->id,
            'checkout_url' => $checkoutUrl,
        ]);
    }
}
