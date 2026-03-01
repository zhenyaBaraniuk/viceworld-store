<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Currency: string implements HasLabel
{
    case UAH = 'uah';
    case USD = 'usd';
    case EUR = 'eur';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::UAH => 'UAH',
            self::USD => 'USD',
            self::EUR => 'EUR',
        };
    }
}
