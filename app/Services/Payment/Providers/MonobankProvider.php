<?php

namespace App\Services\Payment\Providers;

use App\Contracts\PaymentProviderInterface;
use App\Enums\Currency;
use App\Models\Payment;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MonobankProvider implements PaymentProviderInterface
{
    private const string API_URL = 'https://api.monobank.ua';

    private string $key;

    private string $webhookUrl;

    public function __construct()
    {
        $this->key = config('services.monobank.key');
        $this->webhookUrl = config('services.monobank.webhook_url');
    }

    /**
     * @throws ConnectionException
     */
    public function createPayment(Payment $payment): string
    {
        $response = Http::withHeaders([
            'X-Token' => $this->key,
        ])->post(self::API_URL.'/api/merchant/invoice/create',
            [
                'amount' => (int) ($payment->amount * 100),
                'ccy' => $this->ccyCode($payment->currency),
                'redirectUrl' => route('success-order'),
                'webHookUrl' => $this->webhookUrl,
                'merchantPaymInfo' => [
                    'reference' => $payment->id,
                    'destination' => $payment->description,
                ],
            ]);

        return $response->json('pageUrl');
    }

    public function verifyPayment(Request $request): bool
    {
        $signature = $request->header('X-Sign');

        $keyBase64 = Http::withHeaders([
            'X-Token' => $this->key,
        ])->get(self::API_URL.'/api/merchant/pubkey')->json('key');

        $pem = base64_decode($keyBase64);

        $result = openssl_verify(
            $request->getContent(),
            base64_decode($signature),
            $pem,
            OPENSSL_ALGO_SHA256
        );

        return $result === 1;
    }

    public function parseWebhook(Request $request): array
    {
        return $request->json()->all();
    }

    private function ccyCode(Currency $currency): int
    {
        return match ($currency) {
            Currency::UAH => 980,
            Currency::USD => 840,
            Currency::EUR => 978,
        };
    }
}
