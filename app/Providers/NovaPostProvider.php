<?php

namespace App\Providers;

use App\Services\NovaPost\NovaPostClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class NovaPostProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(function (Application $app): NovaPostClient {
            return new NovaPostClient(
                config('services.nova_post.key'),
            );
        });
    }

    public function provides(): array
    {
        return [
            NovaPostClient::class,
        ];
    }
}
