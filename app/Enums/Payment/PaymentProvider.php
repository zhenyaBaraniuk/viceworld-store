<?php

namespace App\Enums\Payment;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentProvider: string implements HasLabel
{
    case LiqPay = 'liqpay';
    case Monobank = 'monobank';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::LiqPay => 'LiqPay',
            self::Monobank => 'Monobank',
        };
    }
}
