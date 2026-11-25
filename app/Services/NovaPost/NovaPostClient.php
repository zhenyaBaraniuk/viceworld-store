<?php

namespace App\Services\NovaPost;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class NovaPostClient
{
    protected string $endpoint = 'https://api.novaposhta.ua/v2.0/json/';

    public function __construct(
        public readonly string $apiToken,
    ) {}

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function getCities(int $page, int $limit): array
    {
        return $this->call('Address', 'getCities', [
            'Page' => (string) $page,
            'Limit' => (string) $limit,
        ]);
    }

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function getWarehouses(int $page, int $limit): array
    {
        return $this->call('Address', 'getWarehouses', [
            'Page' => (string) $page,
            'Limit' => (string) $limit,
        ]);
    }

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    private function call(string $model, string $method, array $props = []): array
    {
        return retry([2000, 4000, 8000, 10000], function () use ($model, $method, $props) {
            $response = $this->client()->post($this->endpoint, [
                'apiKey' => $this->apiToken,
                'modelName' => $model,
                'calledMethod' => $method,
                'methodProperties' => $props,
            ]);

            $json = $response->json();

            if (! ($json['success'] ?? false)) {
                throw new RuntimeException(implode('; ', $json['errors'] ?? ['Nova Post request failed']));
            }

            return $json['data'];
        });
    }

    private function client(): PendingRequest
    {
        return Http::acceptJson()->connectTimeout(10)->timeout(30);
    }
}
