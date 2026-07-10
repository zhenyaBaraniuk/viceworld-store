<?php

namespace App\Services\Pexels;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class PexelsClient
{
    protected string $apiUrl = 'https://api.pexels.com/v1/';

    public function __construct(
        protected readonly string $apiToken,
    ) {}

    public function searchPhotos(string $query, int $count = 4): array
    {
        return $this->client()
            ->get('search', [
                'query' => $query,
                'per_page' => $count,
                'size' => 'small',
                'orientation' => 'portrait',
            ])->throw()->json('photos', []);
    }

    public function searchVideos(string $query, int $count = 2): array
    {
        return $this->client()
            ->get('videos/search', [
                'query' => $query,
                'per_page' => $count,
                'size' => 'small',
                'orientation' => 'landscape',
            ])->throw()->json('videos', []);
    }

    public function tryFetchFile(string $url): string
    {
        return Http::timeout(120)->retry(3, 1000)->get($url)
            ->throw()
            ->body();
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => $this->apiToken,
        ]
        )
            ->acceptJson()
            ->baseUrl($this->apiUrl);
    }
}
