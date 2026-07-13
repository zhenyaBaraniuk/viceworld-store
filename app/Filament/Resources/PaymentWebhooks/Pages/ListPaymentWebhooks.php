<?php

namespace App\Filament\Resources\PaymentWebhooks\Pages;

use App\Filament\Resources\PaymentWebhooks\PaymentWebhookResource;
use Filament\Resources\Pages\ListRecords;

class ListPaymentWebhooks extends ListRecords
{
    protected static string $resource = PaymentWebhookResource::class;
}
