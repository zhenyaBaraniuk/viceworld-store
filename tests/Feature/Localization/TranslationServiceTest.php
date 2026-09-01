<?php

namespace Tests\Feature\Localization;

use App\Services\TranslationService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        File::delete(lang_path('xx.json'));
        File::delete(lang_path('yy.json'));

        parent::tearDown();
    }

    public function test_returns_decoded_map_for_locale(): void
    {
        File::put(lang_path('xx.json'), json_encode(['nav.home' => 'Home']));

        $service = $this->app->make(TranslationService::class);

        $this->assertSame(['nav.home' => 'Home'], $service->forLocale('xx'));
    }

    public function test_returns_empty_array_when_locale_file_is_empty(): void
    {
        File::put(lang_path('yy.json'), '{}');

        $service = $this->app->make(TranslationService::class);

        $this->assertSame([], $service->forLocale('yy'));
    }
}
