<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\Order\OrderStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->options(OrderStatus::class)
                    ->required(),

                Textarea::make('shipping_address')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
