<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Transaction\TransactionStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('external_id'),
                TextInput::make('payment_id'),
                Select::make('provider')
                    ->options(PaymentProvider::class)
                    ->required(),
                TextInput::make('type'),
                Select::make('currency')
                    ->options(Currency::class)
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(TransactionStatus::class)
                    ->required(),
                Textarea::make('provider_response')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
