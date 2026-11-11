<?php

namespace App\Services\NovaPost;

use Illuminate\Http\Client\ConnectionException;
use Throwable;

readonly class NovaPostService
{
    public function __construct(private NovaPostClient $client) {}

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function fetchCityPage(int $page, int $limit): array
    {
        return $this->client->getCities($page, $limit);
    }
}
