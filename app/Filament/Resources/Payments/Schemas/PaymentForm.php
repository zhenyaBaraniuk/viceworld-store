<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\PaymentStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('external_id'),
                Select::make('provider')
                    ->options(PaymentProvider::class)
                    ->required(),
                Select::make('currency')
                    ->options(Currency::class)
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(PaymentStatus::class)
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
