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
     *
     * @throws ConnectionException
     */
    public function getCities(int $page, int $limit): array
    {
        return retry(3, function () use ($page, $limit) {
            $response = $this->client()->post($this->endpoint, [
                'apiKey' => $this->apiToken,
                'modelName' => 'Address',
                'calledMethod' => 'getCities',
                'methodProperties' => [
                    'Page' => (string) $page,
                    'Limit' => (string) $limit,
                ],
            ]);

            $json = json_decode((string)$response->getBody(), true);

            if (! ($json['success'] ?? false)) {
                throw new RuntimeException(implode('; ', $json['errors'] ?? ['Nova Post request failed']));
            }

            return $json['data'];
        }, 500);
    }

    private function client(): PendingRequest
    {
        return Http::acceptJson()->connectTimeout(10)->timeout(30);
    }
}
