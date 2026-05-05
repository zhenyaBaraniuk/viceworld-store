<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GenderLine: string implements HasLabel
{
    case MEN = 'men';
    case WOMEN = 'women';
    case KIDS = 'kids';
    case UNISEX = 'unisex';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::MEN => 'Чоловіки',
            self::WOMEN => 'Жінки',
            self::KIDS => 'Діти',
            self::UNISEX => 'Унісекс',
        };
    }
}
