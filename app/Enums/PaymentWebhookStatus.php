<?php

namespace App\Enums;

enum PaymentWebhookStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case FAILED = 'failed';
}
