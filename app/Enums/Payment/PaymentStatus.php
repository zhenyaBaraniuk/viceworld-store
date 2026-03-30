<?php

namespace App\Enums\Payment;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentStatus: string implements HasColor, HasLabel
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';
    case CANCELLED = 'cancelled';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::PENDING => 'В очікуванні',
            self::PROCESSING => 'В процесі',
            self::PAID => 'Оплачено',
            self::FAILED => 'Помилка',
            self::REFUNDED => 'Відшкодовано',
            self::CANCELLED => 'Скасовано',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::PROCESSING => 'info',
            self::PAID => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'warning',
            self::CANCELLED => 'gray',
        };
    }
}
