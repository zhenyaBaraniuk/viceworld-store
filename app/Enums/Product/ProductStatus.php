<?php

namespace App\Enums\Product;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProductStatus: string implements HasLabel
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case ARCHIVED = 'archived';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::ACTIVE => 'Активний',
            self::DRAFT => 'Прихований',
            self::ARCHIVED => 'В архіві'
        };
    }
}
