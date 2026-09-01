<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeaderFooterLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_and_footer_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('Пошук', $uk['header.search_dialog_title']);
        $this->assertSame('Навігація', $uk['footer.nav_title']);
        $this->assertSame('Отримуй доступ до лімітованих дропів через архівну підписку.', $uk['footer.union_hub_description']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Search', $en['header.search_dialog_title']);
        $this->assertSame('Navigation', $en['footer.nav_title']);
        $this->assertSame('Access limited drops via archival subscription.', $en['footer.union_hub_description']);
    }
}
