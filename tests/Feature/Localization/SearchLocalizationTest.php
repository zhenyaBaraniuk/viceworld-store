<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('Пошук...', $uk['search.placeholder']);
        $this->assertSame('результатів для', $uk['search.results_for']);
        $this->assertSame('товарів', $uk['search.products_label']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Search...', $en['search.placeholder']);
        $this->assertSame('results for', $en['search.results_for']);
        $this->assertSame('products', $en['search.products_label']);
    }
}
