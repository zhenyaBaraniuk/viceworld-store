<?php

namespace App\Services\Payment\Providers;

use App\Contracts\PaymentProviderInterface;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LiqPay;

class LiqPayProvider implements PaymentProviderInterface
{
    private LiqPay $client;
    private string $publicKey;
    private string $privateKey;

    public function __construct()
    {
        $this->publicKey = config('services.liqpay.public_key');
        $this->privateKey = config('services.liqpay.private_key');

        $this->client = new LiqPay(
            $this->publicKey,
            $this->privateKey,
        );
    }

    public function createPayment(Payment $payment): string
    {
        $data = $this->client->cnb_form_raw([
            'action' => 'pay',
            'amount' => $payment->amount,
            'currency' => Str::upper($payment->currency->value),
            'description' => $payment->description,
            'order_id' => $payment->id,
            'version' => '3'
        ]);

        return $data['url'] . '?' . http_build_query([
                'data' => $data['data'],
                'signature' => $data['signature']
            ]);
    }

    public function verifyPayment(Request $request): bool
    {
        $data = $request->input('data');
        $signature = $request->input('signature');

        $expectedSignature = $this->client->str_to_sign(
            $this->privateKey . $data . $this->privateKey
        );

        return $signature === $expectedSignature;
    }

    public function parseWebhook(Request $request): array
    {
        return $this->client->decode_params($request->input('data'));
    }
}
