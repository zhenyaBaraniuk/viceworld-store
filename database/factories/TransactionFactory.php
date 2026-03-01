<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\PaymentProvider;
use App\Enums\TransactionStatus;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'external_id' => $this->faker->numerify('##########'),
            'payment_id' => Payment::factory(),
            'provider' => $this->faker->randomElement(PaymentProvider::cases()),
            'type' => $this->faker->randomElement(['payment', 'refund']),
            'currency' => $this->faker->randomElement(Currency::cases()),
            'amount' => $this->faker->randomFloat(1, 50, 1000),
            'status' => $this->faker->randomElement(TransactionStatus::cases()),
            'provider_response' => json_encode(['status' => 'ok', 'transaction_id' => $this->faker->randomNumber(8)]),
        ];
    }
}
