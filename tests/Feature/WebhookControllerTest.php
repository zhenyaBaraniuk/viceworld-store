<?php

namespace tests\Feature;

use App\Contracts\PaymentProviderInterface;
use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\PaymentWebhook\PaymentWebhookStatus;
use App\Models\Payment;
use App\Models\PaymentWebhook;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use PaymentManager;
use Tests\TestCase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_liqpay_webhook(): void
    {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $providerMock = $this->mockProvider(PaymentProvider::LiqPay);

        $providerMock->shouldReceive('parseWebhook')
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
    public function test_liqpay_maps_different_statuses_correctly(
        string $liqpayStatus,
        string $expectedPaymentStatus,
        string $expectedTransactionStatus,
    ): void
    {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $providerMock = $this->mockProvider(PaymentProvider::LiqPay);

        $providerMock->shouldReceive('parseWebhook')
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
        $providerMock = $this->mockProvider(PaymentProvider::LiqPay);

        $providerMock->shouldReceive('parseWebhook')
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

    public function test_liqpay_fails_verify_payment(): void
    {
        $this->mockProvider(PaymentProvider::LiqPay, false);

        $response = $this->postJson('/api/webhooks/liqpay', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('payment_webhooks', [
            'is_valid' => 0,
        ]);
    }

    public function test_can_create_monobank_webhook(): void
    {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $providerMock = $this->mockProvider(PaymentProvider::Monobank);

        $providerMock->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'invoiceId' => 'inv_123',
                'reference' => $payment->id,
                'ccy' => 980,
                'amount' => 10000,
                'status' => 'success',
            ]);

        $response = $this->postJson('/api/webhooks/monobank', [
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
            'provider' => PaymentProvider::Monobank->value,
            'is_valid' => 1,
            'status' => PaymentWebhookStatus::SUCCESS->value,
            'type' => 'debit',
            'processed_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('payments', [
            'external_id' => 'inv_123',
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('transactions', [
            'external_id' => 'inv_123',
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::Monobank->value,
            'currency' => Currency::UAH->value,
            'amount' => 100,
            'type' => 'debit',
            'status' => 'success',
        ]);
    }

    /**
     * @dataProvider monobankStatusProvider
     */
    public function test_monobank_maps_different_statuses_correctly(
        string $monobankStatus,
        string $expectedPaymentStatus,
        string $expectedTransactionStatus,
    ): void
    {
        $this->freezeTime();

        $payment = Payment::factory()->create();

        $providerMock = $this->mockProvider(PaymentProvider::Monobank);

        $providerMock->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'invoiceId' => 'inv_123',
                'reference' => $payment->id,
                'ccy' => 980,
                'amount' => 10000,
                'status' => $monobankStatus,
            ]);

        $response = $this->postJson('/api/webhooks/monobank', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $transaction = Transaction::first();

        $response->assertStatus(200);

        $this->assertDatabaseHas('payment_webhooks', [
            'transaction_id' => $transaction->id,
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::Monobank->value,
            'is_valid' => 1,
            'status' => PaymentWebhookStatus::SUCCESS->value,
            'type' => 'debit',
            'processed_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('payments', [
            'external_id' => 'inv_123',
            'status' => $expectedPaymentStatus,
        ]);

        $this->assertDatabaseHas('transactions', [
            'external_id' => 'inv_123',
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::Monobank->value,
            'currency' => Currency::UAH->value,
            'amount' => 100,
            'type' => 'debit',
            'status' => $expectedTransactionStatus,
        ]);
    }

    public function test_can_create_monobank_webhook_when_payment_does_not_exist(): void
    {
        $providerMock = $this->mockProvider(PaymentProvider::Monobank);

        $providerMock->shouldReceive('parseWebhook')
            ->once()
            ->andReturn([
                'invoiceId' => 'inv_123',
                'reference' => 'Payment not exist',
                'ccy' => 980,
                'amount' => 10000,
                'status' => 'success',
            ]);

        $response = $this->postJson('/api/webhooks/monobank', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $response->assertStatus(404);

        $this->assertDatabaseHas('payment_webhooks', [
            'status' => PaymentWebhookStatus::FAILED->value,
        ]);
    }

    public function test_monobank_fails_verify_payment(): void
    {
        $this->mockProvider(PaymentProvider::Monobank, false);

        $response = $this->postJson('/api/webhooks/monobank', [
            'data' => 'fake_data',
            'signature' => 'fake_signature',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('payment_webhooks', [
            'is_valid' => 0,
        ]);
    }

    private function mockProvider(PaymentProvider $provider, bool $isVerified = true): MockInterface&PaymentProviderInterface
    {
        $mockProvider = Mockery::mock(PaymentProviderInterface::class);

        $this->mock(PaymentManager::class)
            ->shouldReceive('provider')
            ->with($provider)
            ->once()
            ->andReturn($mockProvider);

        $mockProvider->shouldReceive('verifyPayment')
            ->once()
            ->andReturn($isVerified);

        return $mockProvider;
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

    public static function monobankStatusProvider(): array
    {
        return [
            'success' => ['success', 'paid', 'success'],
            'created' => ['created', 'processing', 'pending'],
            'reversed' => ['reversed', 'refunded', 'reversed'],
            'error' => ['error', 'failed', 'failed'],
            'failure' => ['failure', 'failed', 'failed'],
            'default' => ['unknown', 'processing', 'processing'],
        ];
    }
}
