<?php

namespace App\Http\Middleware;

use App\Http\Middleware\SharedData\MenuSharedData;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function __construct(
        private readonly MenuSharedData $menuSharedData,
    ) {}

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            ...$this->menuSharedData->resolve($request),
        ];
    }
}
