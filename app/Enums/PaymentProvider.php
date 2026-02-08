<?php

namespace App\Enums;

enum PaymentProvider: string
{
    case LiqPay = 'liqpay';
    case Monobank = 'monobank';
}
