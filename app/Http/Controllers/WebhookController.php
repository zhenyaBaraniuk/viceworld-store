<?php

namespace App\Http\Controllers;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Enums\PaymentWebhookStatus;
use App\Enums\TransactionStatus;
use App\Models\PaymentWebhook;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Payment;

use PaymentManager;

class WebhookController
{
    public function __construct(private readonly PaymentManager $paymentManager)
    {
    }

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

        if (!$isVerified) {
            return response('Invalid signature', 403);
        }

        $data = $liqpayProvider->parseWebhook($request);

        $payment = Payment::find($data['order_id']);

        $transaction = Transaction::create([
            'external_id' => $data['payment_id'],
            'payment_id' => $payment->id,
            'provider' => PaymentProvider::LiqPay,
            'currency' => Str::lower($data['currency']),
            'amount' => $data['amount'],
            'type' => $data['action'],
            'status' => $this->mapTransactionStatus($data['status']),
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

    public function monobank()
    {

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

    private function mapTransactionStatus(string $status): TransactionStatus
    {
        return match ($status) {
            'success' => TransactionStatus::SUCCESS,
            'prepared' => TransactionStatus::PENDING,
            'error', 'failure' => TransactionStatus::FAILED,
            default => TransactionStatus::PROCESSING,
        };
    }
}
