<?php

namespace App\Providers;

use App\Services\Pexels\PexelsClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PexelsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(function (Application $app): \App\Services\Pexels\PexelsClient {
            return new PexelsClient(
                config('services.pexels.key'),
            );
        });
    }

    public function provides(): array
    {
        return [
            PexelsClient::class,
        ];
    }
}
