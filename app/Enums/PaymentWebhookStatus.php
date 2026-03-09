<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentWebhookStatus: string implements HasColor, HasLabel
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case FAILED = 'failed';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::SUCCESS => __('Успішно'),
            self::PENDING => __('В очікуванні'),
            self::PROCESSING => __('В процесі'),
            self::FAILED => __('Помилка'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUCCESS => 'green',
            self::PENDING => 'gray',
            self::PROCESSING => 'info',
            self::FAILED => 'danger',
        };
    }
}
