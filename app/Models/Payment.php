<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string|null $external_id
 * @property Currency $currency
 * @property PaymentProvider $provider
 * @property PaymentStatus $status
 * @property float $amount
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property-read Collection<PaymentWebhook> $paymentWebhooks
 * @property-read Collection<Transaction> $transactions
 */
class Payment extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'external_id',
        'provider',
        'amount',
        'currency',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'provider' => PaymentProvider::class,
            'currency' => Currency::class,
            'status' => PaymentStatus::class,
        ];
    }

    /**
     * @return HasOne<Order, $this>
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /**
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return HasMany<PaymentWebhook, $this>
     */
    public function paymentWebhooks(): HasMany
    {
        return $this->hasMany(PaymentWebhook::class);
    }
}
