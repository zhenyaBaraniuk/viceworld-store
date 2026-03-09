<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use Illuminate\Http\JsonResponse;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use PaymentManager;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentManager $paymentManager)
    {
    }

    public function store(CreatePaymentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $payment = Payment::create([
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'provider' => $data['provider'],
            'description' => $data['description'],
            'status' => PaymentStatus::PENDING,
        ]);

        $checkoutUrl = $this->paymentManager->provider($data['provider'])->createPayment($payment);

        return response()->json([
            'payment_id' => $payment->id,
            'checkout_url' => $checkoutUrl,
        ]);
    }
}
