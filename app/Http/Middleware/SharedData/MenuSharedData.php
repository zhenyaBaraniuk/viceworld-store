<?php

namespace App\Http\Middleware\SharedData;

use App\Services\NavigationService;
use Illuminate\Http\Request;

class MenuSharedData
{
    private const EXCLUDED_ROUTES = ['checkout', 'success-order'];

    public function __construct(
        private readonly NavigationService $navigationService
    ) {}

    public function resolve(Request $request): array
    {
        return [
            'nav_categories' => fn () => $request->routeIs(...self::EXCLUDED_ROUTES)
                ? []
                : $this->navigationService->getCategories(),
        ];
    }
}
