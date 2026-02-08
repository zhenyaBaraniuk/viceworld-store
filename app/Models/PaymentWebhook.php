<?php

namespace App\Models;

use App\Enums\PaymentProvider;
use App\Enums\PaymentWebhookStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentWebhook extends Model
{
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
        'status'   => PaymentWebhookStatus::class,
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
