<?php

namespace tests\Feature;

use App\Contracts\PaymentProviderInterface;
use App\Enums\Currency;
use App\Enums\PaymentProvider;
use App\Enums\PaymentWebhookStatus;
use App\Models\Payment;
use App\Models\PaymentWebhook;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PaymentManager;
use Tests\TestCase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_liqpay_webhook(): void
    {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn(true);

        $mockProvider->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'order_id' => $payment->id,
                'payment_id' => 12345,
                'currency' => Currency::EUR->value,
                'amount' => 100,
                'action' => 'pay',
                'status' => 'success',
            ]);

        $response = $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $webhook = PaymentWebhook::first();
        $transaction = Transaction::first();

        $response->assertStatus(200);

        $this->assertEquals(['data' => 'fake_data', 'signature' => 'fake_signature'], $webhook->payload);

        $this->assertDatabaseHas('payment_webhooks', [
            'transaction_id' => $transaction->id,
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay->value,
            'is_valid' => 1,
            'status' => PaymentWebhookStatus::SUCCESS->value,
            'type' => 'pay',
            'processed_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('payments', [
            'external_id' => 12345,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('transactions', [
            'external_id' => 12345,
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay->value,
            'currency' => Currency::EUR->value,
            'amount' => 100,
            'type' => 'pay',
            'status' => 'success',
        ]);
    }

    /**
     * @dataProvider liqpayStatusProvider
     */
    public function test_maps_different_statuses_correctly(
        string $liqpayStatus,
        string $expectedPaymentStatus,
        string $expectedTransactionStatus,
    ): void {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn(true);

        $mockProvider->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'order_id' => $payment->id,
                'payment_id' => 12345,
                'currency' => Currency::EUR->value,
                'amount' => 100,
                'action' => 'pay',
                'status' => $liqpayStatus,
            ]);

        $response = $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $transaction = Transaction::first();

        $response->assertStatus(200);

        $this->assertDatabaseHas('payment_webhooks', [
            'transaction_id' => $transaction->id,
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay->value,
            'is_valid' => 1,
            'status' => PaymentWebhookStatus::SUCCESS->value,
            'type' => 'pay',
            'processed_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('payments', [
            'external_id' => 12345,
            'status' => $expectedPaymentStatus,
        ]);

        $this->assertDatabaseHas('transactions', [
            'external_id' => 12345,
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay->value,
            'currency' => Currency::EUR->value,
            'amount' => 100,
            'type' => 'pay',
            'status' => $expectedTransactionStatus,
        ]);
    }

    public function test_can_create_liqpay_webhook_when_payment_does_not_exist(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn(true);

        $mockProvider->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'order_id' => 'Not exist id',
                'payment_id' => 12345,
                'currency' => Currency::EUR->value,
                'amount' => 100,
                'action' => 'pay',
                'status' => 'success',
            ]);

        $response = $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $response->assertStatus(404);

        $this->assertDatabaseHas('payment_webhooks', [
            'status' => PaymentWebhookStatus::FAILED->value,
        ]);
    }

    public function test_webhook_is_saved_with_pending_status_before_parse_webhook(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn(true);

        $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $this->assertDatabaseHas('payment_webhooks', [
            'status' => PaymentWebhookStatus::PENDING->value,
        ]);
    }

    public function test_fails_verify_payment(): void
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with(PaymentProvider::LiqPay)
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn(false);

        $response = $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('payment_webhooks', [
            'is_valid' => 0,
        ]);
    }

    public static function liqpayStatusProvider(): array
    {
        return [
            'success' => ['success', 'paid', 'success'],
            'reversed' => ['reversed', 'refunded', 'reversed'],
            'cancelled' => ['cancelled', 'cancelled', 'processing'],
            'prepared' => ['prepared', 'processing', 'pending'],
            'error' => ['error', 'failed', 'failed'],
            'failure' => ['failure', 'failed', 'failed'],
            'default' => ['unknown', 'processing', 'processing'],
        ];
    }
}
