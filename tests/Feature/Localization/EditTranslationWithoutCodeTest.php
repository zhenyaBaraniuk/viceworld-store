<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EditTranslationWithoutCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_changing_locale_file_value_changes_response_without_code_changes(): void
    {
        $path = lang_path('uk.json');
        $original = File::get($path);

        $data = json_decode($original, true);
        $key = 'header.search_dialog_title';

        $this->assertArrayHasKey(
            $key,
            $data,
            'Fixture key must already be referenced by a migrated component (Header.tsx).'
        );

        $data[$key] = 'ЗМІНЕНИЙ ТЕКСТ БЕЗ ПРАВОК КОДУ';
        File::put($path, json_encode($data, JSON_UNESCAPED_UNICODE));

        try {
            $translations = $this->inertiaProps($this->get('/uk/search'))['translations'];

            $this->assertSame('ЗМІНЕНИЙ ТЕКСТ БЕЗ ПРАВОК КОДУ', $translations[$key]);
        } finally {
            File::put($path, $original);
        }
    }
}
