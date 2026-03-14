<?php

namespace App\Models;

use App\Enums\PaymentProvider;
use App\Enums\PaymentWebhookStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $payment_id
 * @property string $transaction_id
 * @property array $headers
 * @property array $payload
 * @property PaymentProvider $provider
 * @property PaymentWebhookStatus $status
 * @property string|null $type
 * @property bool $is_active
 * @property Carbon $processed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property-read Payment $payment
 * @property-read Transaction $transaction
 */
class PaymentWebhook extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'payment_id',
        'transaction_id',
        'provider',
        'type',
        'status',
        'headers',
        'payload',
        'is_valid',
        'processed_at',
    ];

    protected $casts = [
        'provider' => PaymentProvider::class,
        'status' => PaymentWebhookStatus::class,
        'headers' => 'array',
        'payload' => 'array',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
