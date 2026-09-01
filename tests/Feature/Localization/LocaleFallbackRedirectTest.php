<?php

namespace Tests\Feature\Localization;

use Tests\TestCase;

class LocaleFallbackRedirectTest extends TestCase
{
    public function test_missing_locale_prefix_redirects_to_default_locale(): void
    {
        $default = config('app.locale');

        $this->get('/catalog')->assertRedirect("/{$default}/catalog");
    }

    public function test_unsupported_locale_prefix_redirects_to_default_locale(): void
    {
        $default = config('app.locale');

        $this->get('/fr/catalog')->assertRedirect("/{$default}/catalog");
    }

    public function test_valid_locale_prefix_with_unmatched_path_returns_not_found(): void
    {
        $this->get('/uk/this-page-does-not-exist')->assertNotFound();
    }
}
