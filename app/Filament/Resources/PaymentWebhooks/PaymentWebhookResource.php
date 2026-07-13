<?php

namespace App\Filament\Resources\PaymentWebhooks;

use App\Filament\Resources\PaymentWebhooks\Pages\ListPaymentWebhooks;
use App\Filament\Resources\PaymentWebhooks\Pages\ViewPaymentWebhook;
use App\Filament\Resources\PaymentWebhooks\Schemas\PaymentWebhookForm;
use App\Filament\Resources\PaymentWebhooks\Schemas\PaymentWebhookInfolist;
use App\Filament\Resources\PaymentWebhooks\Tables\PaymentWebhooksTable;
use App\Models\PaymentWebhook;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PaymentWebhookResource extends Resource
{
    protected static ?string $model = PaymentWebhook::class;

    protected static string|null|UnitEnum $navigationGroup = 'Payments';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    public static function form(Schema $schema): Schema
    {
        return PaymentWebhookForm::configure($schema);
    }

    public static function getRecordTitle(?Model $record): string|Htmlable|null
    {
        return 'Webhook';
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaymentWebhookInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentWebhooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPaymentWebhooks::route('/'),
            'view' => ViewPaymentWebhook::route('/{record}'),
        ];
    }
}
