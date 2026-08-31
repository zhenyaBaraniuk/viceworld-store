<?php

namespace App\Models;

use App\Enums\Order\DeliveryMethod;
use App\Enums\Order\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Order extends Model
{
    use HasUlids;

    protected $fillable = [
        'customer_id',
        'payment_id',
        'cart_id',
        'status',
        'total_amount',
        'shipping_address',
        'delivery_method',
        'email',
        'phone',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status' => OrderStatus::class,
        'phone' => E164PhoneNumberCast::class.':UA',
        'shipping_address' => 'array',
        'delivery_method' => DeliveryMethod::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order): void {
            $order->order_number = (string) (static::query()->max('order_number') + 1);
        });
    }

    /**
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo<Payment, $this>
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @return BelongsTo<Cart, $this>
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
