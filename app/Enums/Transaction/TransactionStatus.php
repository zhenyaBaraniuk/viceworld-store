<?php

namespace App\Enums\Transaction;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TransactionStatus: string implements HasColor, HasLabel
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case REVERSED = 'reversed';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::PENDING => __('В очікуванні'),
            self::PROCESSING => __('В процесі'),
            self::REVERSED => __('Повернуто'),
            self::SUCCESS => __('Успіх'),
            self::FAILED => __('Помилка'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::PROCESSING => 'info',
            self::REVERSED => 'warning',
            self::SUCCESS => 'success',
            self::FAILED => 'danger',
        };
    }
}
