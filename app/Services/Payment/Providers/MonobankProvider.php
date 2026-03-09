<?php

namespace App\Services\Payment\Providers;

use App\Contracts\PaymentProviderInterface;
use App\Models\Payment;
use Illuminate\Http\Request;

class MonobankProvider implements PaymentProviderInterface
{
    public function createPayment(Payment $payment): string
    {
        // TODO: Implement createPayment() method.
    }

    public function verifyPayment(Request $request): bool
    {
        // TODO: Implement verifyPayment() method.
    }

    public function parseWebhook(Request $request): array
    {
        // TODO: Implement parseWebhook() method.
    }
}
