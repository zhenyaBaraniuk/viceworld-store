<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\PaymentProvider;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
