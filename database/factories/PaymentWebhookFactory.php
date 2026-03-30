<?php

namespace Database\Factories;

use App\Enums\Payment\PaymentProvider;
use App\Enums\PaymentWebhook\PaymentWebhookStatus;
use App\Models\Payment;
use App\Models\PaymentWebhook;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentWebhook>
 */
class PaymentWebhookFactory extends Factory
{
    protected $model = PaymentWebhook::class;

    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'payment_id' => Payment::factory(),
            'provider' => $this->faker->randomElement(PaymentProvider::cases()),
            'type' => $this->faker->randomElement(['payment', 'refund']),
            'status' => $this->faker->randomElement(PaymentWebhookStatus::cases()),
            'headers' => json_encode(['Content-Type' => 'application/json', 'X-Signature' => $this->faker->sha256()]),
            'payload' => json_encode(['status' => 'ok', 'transaction_id' => $this->faker->sentence()]),
            'is_valid' => $this->faker->boolean(),
            'processed_at' => $this->faker->dateTimeBetween('- 30 days'),
        ];
    }
}
