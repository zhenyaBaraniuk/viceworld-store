<?php

namespace App\Enums\Order;

enum OrderStatus: string
{
    case PENDING = 'pending';

    case PAID = 'paid';

    case PROCESSING = 'processing';

    case SHIPPED = 'shipped';

    case DELIVERED = 'delivered';

    case CANCELLED = 'cancelled';

    case REFUNDED = 'refunded';
}
