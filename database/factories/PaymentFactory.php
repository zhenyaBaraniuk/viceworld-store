<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'external_id' => $this->faker->numerify('##########'),
            'provider' => $this->faker->randomElement(PaymentProvider::cases()),
            'amount' => $this->faker->randomFloat(1, 50, 1000),
            'currency' => $this->faker->randomElement(Currency::cases()),
            'status' => $this->faker->randomElement(PaymentStatus::cases()),
            'description' => $this->faker->sentence(),
        ];
    }
}
