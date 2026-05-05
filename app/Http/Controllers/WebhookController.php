<?php

namespace App\Http\Controllers;

use App\Enums\Currency;
use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\PaymentStatus;
use App\Enums\PaymentWebhook\PaymentWebhookStatus;
use App\Enums\Transaction\TransactionStatus;
use App\Models\Payment;
use App\Models\PaymentWebhook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PaymentManager;

class WebhookController
{
    public function __construct(private readonly PaymentManager $paymentManager) {}

    public function liqpay(Request $request): Response
    {
        $liqpayProvider = $this->paymentManager->provider(PaymentProvider::LiqPay);

        $isVerified = $liqpayProvider->verifyPayment($request);

        $webhook = PaymentWebhook::create([
            'provider' => PaymentProvider::LiqPay,
            'is_valid' => $isVerified,
            'status' => PaymentWebhookStatus::PENDING,
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
        ]);

        if (! $isVerified) {
            return response('Invalid signature', 403);
        }

        $data = $liqpayProvider->parseWebhook($request);

        $payment = Payment::find($data['order_id']);

        if (! $payment) {
            $webhook->update([
                'status' => PaymentWebhookStatus::FAILED,
            ]);

            return response('Payment not found', 404);
        }

        $transaction = Transaction::create([
            'external_id' => $data['payment_id'],
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay,
            'currency' => Str::lower($data['currency']),
            'amount' => $data['amount'],
            'type' => $data['action'],
            'status' => $this->mapLiqpayTransactionStatus($data['status']),
            'provider_response' => $data,
        ]);

        $payment->update([
            'external_id' => $data['payment_id'],
            'status' => $this->mapPaymentStatus($data['status']),
        ]);

        $webhook->update([
            'payment_id' => $payment->id,
            'transaction_id' => $transaction->id,
            'status' => PaymentWebhookStatus::SUCCESS,
            'type' => $data['action'],
            'processed_at' => now(),
        ]);

        return response('OK', 200);
    }

    public function monobank(Request $request): Response
    {
        $monobankProvider = $this->paymentManager->provider(PaymentProvider::Monobank);

        $isVerified = $monobankProvider->verifyPayment($request);

        $webhook = PaymentWebhook::create([
            'provider' => PaymentProvider::Monobank,
            'is_valid' => $isVerified,
            'status' => PaymentWebhookStatus::PENDING,
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
        ]);

        if (! $isVerified) {
            return response('Invalid signature', 403);
        }

        $data = $monobankProvider->parseWebhook($request);

        $payment = Payment::find($data['reference']);

        if (! $payment) {
            $webhook->update([
                'status' => PaymentWebhookStatus::FAILED,
            ]);

            return response('Payment not found', 404);
        }

        $transaction = Transaction::create([
            'external_id' => $data['invoiceId'],
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::Monobank,
            'currency' => $this->mapCurrency($data['ccy']),
            'amount' => $data['amount'] / 100,
            'type' => 'debit',
            'status' => $this->mapMonobankTransactionStatus($data['status']),
            'provider_response' => $data,
        ]);

        $payment->update([
            'external_id' => $data['invoiceId'],
            'status' => $this->mapPaymentStatus($data['status']),
        ]);

        $webhook->update([
            'payment_id' => $payment->id,
            'transaction_id' => $transaction->id,
            'status' => PaymentWebhookStatus::SUCCESS,
            'type' => 'debit',
            'processed_at' => now(),
        ]);

        return response('OK', 200);
    }

    private function mapPaymentStatus(string $status): PaymentStatus
    {
        return match ($status) {
            'success' => PaymentStatus::PAID,
            'reversed' => PaymentStatus::REFUNDED,
            'cancelled' => PaymentStatus::CANCELLED,
            'error', 'failure' => PaymentStatus::FAILED,
            default => PaymentStatus::PROCESSING,
        };
    }

    private function mapLiqpayTransactionStatus(string $status): TransactionStatus
    {
        return match ($status) {
            'success' => TransactionStatus::SUCCESS,
            'prepared' => TransactionStatus::PENDING,
            'reversed' => TransactionStatus::REVERSED,
            'error', 'failure' => TransactionStatus::FAILED,
            default => TransactionStatus::PROCESSING,
        };
    }

    private function mapMonobankTransactionStatus(string $status): TransactionStatus
    {
        return match ($status) {
            'success' => TransactionStatus::SUCCESS,
            'created' => TransactionStatus::PENDING,
            'reversed' => TransactionStatus::REVERSED,
            'error', 'failure' => TransactionStatus::FAILED,
            default => TransactionStatus::PROCESSING,
        };
    }

    private function mapCurrency(int $ccy): Currency
    {
        return match ($ccy) {
            980 => Currency::UAH,
            840 => Currency::USD,
            978 => Currency::EUR,
            default => throw new InvalidArgumentException("Unsupported currency code: {$ccy}"),
        };
    }
}
