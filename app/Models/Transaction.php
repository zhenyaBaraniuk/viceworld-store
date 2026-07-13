<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Transaction\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $payment_id
 * @property string|null $external_id
 * @property string $amount
 * @property string $type
 * @property Currency $currency
 * @property TransactionStatus $status
 * @property PaymentProvider $provider
 * @property array $provider_response
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property-read Payment $payment
 * @property-read Collection<PaymentWebhook> $paymentWebhooks
 */
class Transaction extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'external_id',
        'payment_id',
        'provider',
        'type',
        'currency',
        'amount',
        'status',
        'provider_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'provider' => PaymentProvider::class,
            'currency' => Currency::class,
            'status' => TransactionStatus::class,
            'provider_response' => 'array',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function paymentWebhooks(): HasMany
    {
        return $this->hasMany(PaymentWebhook::class);
    }
}
