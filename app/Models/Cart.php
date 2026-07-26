<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $customer_id
 * @property string $session_token
 */
class Cart extends Model
{
    use HasUlids;

    protected $fillable = [
        'customer_id',
        'session_token',
    ];

    /**
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasMany<CartItem, $this>
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalPrice(): float
    {
        return $this->cartItems
            ->sum(fn (CartItem $cartItem) => (float) $cartItem->productVariant->product->price * $cartItem->quantity);
    }
}
