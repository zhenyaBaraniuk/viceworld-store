<?php

namespace App\Contracts;

use App\Models\Payment;
use Illuminate\Http\Request;

interface PaymentProviderInterface
{
    public function createPayment(Payment $payment): string;
    public function verifyPayment(Request $request): bool;
    public function parseWebhook(Request $request): array;
}
