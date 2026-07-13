<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('customer.full_name')
                    ->placeholder('-'),

                TextEntry::make('payment.external_id')
                    ->placeholder('-'),

                TextEntry::make('order_number'),

                TextEntry::make('status')
                    ->badge(),

                TextEntry::make('total_amount')
                    ->numeric(),

                TextEntry::make('shipping_address')
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
