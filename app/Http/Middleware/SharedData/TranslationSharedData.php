<?php

namespace App\Http\Middleware\SharedData;

use App\Services\TranslationService;
use Illuminate\Http\Request;

class TranslationSharedData
{
    public function __construct(
        private readonly TranslationService $translationService
    ) {}

    public function resolve(Request $request): array
    {
        return [
            'translations' => fn () => $this->translationService->forLocale(app()->getLocale()),
        ];
    }
}
