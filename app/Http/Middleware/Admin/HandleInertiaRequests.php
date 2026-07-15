<?php

namespace App\Http\Middleware\Admin;

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
            'locale' => app()->getLocale(),
            'auth' => [
                'customer' => $request->user('customer'),
            ],
            ...parent::share($request),
            ...$this->menuSharedData->resolve($request),
        ];
    }
}
