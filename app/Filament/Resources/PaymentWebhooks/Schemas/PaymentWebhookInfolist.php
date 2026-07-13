<?php

namespace App\Filament\Resources\PaymentWebhooks\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentWebhookInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('payment.id')
                    ->label('Payment')
                    ->placeholder('-'),
                TextEntry::make('transaction.id')
                    ->label('Transaction')
                    ->placeholder('-'),
                TextEntry::make('provider')
                    ->badge(),
                TextEntry::make('type'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('headers')
                    ->columnSpanFull(),
                TextEntry::make('payload')
                    ->columnSpanFull(),
                IconEntry::make('is_valid')
                    ->boolean(),
                TextEntry::make('processed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
