<?php

namespace App\Filament\Resources\PaymentWebhooks\Schemas;

use App\Enums\Payment\PaymentProvider;
use App\Enums\PaymentWebhook\PaymentWebhookStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaymentWebhookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('payment_id')
                    ->relationship('payment', 'id'),
                Select::make('transaction_id')
                    ->relationship('transaction', 'id'),
                Select::make('provider')
                    ->options(PaymentProvider::class)
                    ->required(),
                TextInput::make('type')
                    ->required(),
                Select::make('status')
                    ->options(PaymentWebhookStatus::class)
                    ->required(),
                Textarea::make('headers')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('payload')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_valid')
                    ->required(),
                DateTimePicker::make('processed_at'),
            ]);
    }
}
