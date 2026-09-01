<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MissingKeyDoesNotBreakPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_still_returns_ok_when_a_referenced_key_is_missing(): void
    {
        $path = lang_path('uk.json');
        $original = File::get($path);

        $data = json_decode($original, true);
        unset($data['header.search_dialog_title']);
        File::put($path, json_encode($data, JSON_UNESCAPED_UNICODE));

        try {
            $response = $this->get('/uk/search');

            $response->assertOk();

            $translations = $this->inertiaProps($response)['translations'];
            $this->assertArrayNotHasKey('header.search_dialog_title', $translations);
        } finally {
            File::put($path, $original);
        }
    }
}
