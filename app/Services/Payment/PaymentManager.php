<?php

use App\Contracts\PaymentProviderInterface;
use App\Enums\PaymentProvider;
use App\Services\Payment\Providers\LiqPayProvider;
use App\Services\Payment\Providers\MonobankProvider;

class PaymentManager
{
    public function provider(PaymentProvider $provider): PaymentProviderInterface
    {
        return match ($provider) {
            PaymentProvider::LiqPay => new LiqPayProvider,
            PaymentProvider::Monobank => new MonobankProvider,
        };
    }
}
