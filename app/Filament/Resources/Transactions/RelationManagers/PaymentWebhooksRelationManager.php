<?php

namespace App\Filament\Resources\Transactions\RelationManagers;

use App\Filament\Resources\PaymentWebhooks\PaymentWebhookResource;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentWebhooksRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentWebhooks';

    protected static ?string $relatedResource = PaymentWebhookResource::class;
}
