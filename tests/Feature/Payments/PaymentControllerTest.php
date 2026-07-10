<?php

namespace Tests\Feature\Payments;

use App\Contracts\PaymentProviderInterface;
use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\PaymentStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PaymentManager;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_payment(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);
        $mockProvider->shouldReceive('createPayment')
            ->once()
            ->andReturn('https://checkout.liqpay.ua/fake');

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $response = $this->postJson('/api/payments', [
            'amount' => 100,
            'currency' => 'uah',
            'provider' => PaymentProvider::LiqPay->value,
            'description' => 'Test payment',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['payment_id', 'checkout_url'])
            ->assertJsonFragment(['checkout_url' => 'https://checkout.liqpay.ua/fake']);

        $this->assertDatabaseHas('payments', [
            'amount' => '100.00',
            'currency' => Currency::UAH->value,
            'provider' => PaymentProvider::LiqPay->value,
            'status' => PaymentStatus::PENDING->value,
            'description' => 'Test payment',
        ]);
    }

    public function test_is_saved_with_pending_status(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);
        $mockProvider->shouldReceive('createPayment')
            ->once()
            ->andReturn('https://checkout.liqpay.ua/fake');

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $response = $this->postJson('/api/payments', [
            'amount' => 100,
            'currency' => 'uah',
            'provider' => PaymentProvider::LiqPay->value,
            'description' => 'Test payment',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('payments', [
            'status' => PaymentStatus::PENDING->value,
        ]
        );
    }

    public function test_without_description(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);
        $mockProvider->shouldReceive('createPayment')
            ->once()
            ->andReturn('https://checkout.liqpay.ua/fake');

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $response = $this->postJson('/api/payments', [
            'amount' => '100.00',
            'currency' => Currency::UAH->value,
            'provider' => PaymentProvider::LiqPay->value,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['payment_id', 'checkout_url'])
            ->assertJsonFragment(['checkout_url' => 'https://checkout.liqpay.ua/fake']);

        $this->assertDatabaseHas('payments', [
            'amount' => '100.00',
            'currency' => Currency::UAH->value,
            'provider' => PaymentProvider::LiqPay->value,
            'status' => PaymentStatus::PENDING->value,
        ]);
    }

    public function test_fails_without_required_fields(): void
    {
        $response = $this->postJson('/api/payments', [
            'description' => 'Test payment',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['amount', 'currency', 'provider']);
    }

    public function test_fails_with_invalid_amount(): void
    {
        $response = $this->postJson('/api/payments', [
            'amount' => -1,
            'currency' => Currency::UAH->value,
            'provider' => PaymentProvider::LiqPay->value,
            'description' => 'Test payment',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('amount');
    }

    public function test_fails_with_invalid_currency(): void
    {
        $response = $this->postJson('/api/payments', [
            'amount' => '100.00',
            'currency' => 'test',
            'provider' => PaymentProvider::LiqPay->value,
            'description' => 'Test payment',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('currency');
    }

    public function test_fails_with_invalid_provider(): void
    {
        $response = $this->postJson('/api/payments', [
            'amount' => '100.00',
            'currency' => Currency::UAH->value,
            'provider' => 'test',
            'description' => 'Test payment',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('provider');
    }

    public function test_fails_with_invalid_description(): void
    {
        $response = $this->postJson('/api/payments', [
            'amount' => '100.00',
            'currency' => Currency::UAH->value,
            'provider' => PaymentProvider::LiqPay->value,
            'description' => 111,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('description');
    }
}
