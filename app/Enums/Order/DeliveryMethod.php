<?php

namespace App\Enums\Order;

enum DeliveryMethod: string
{
    case COURIER = 'courier';
    case PICKUP = 'pickup';
}
