<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('КАТАЛОГ', $uk['catalog.hero_watermark']);
        $this->assertSame('Усі товари', $uk['catalog.hero_meta']);
        $this->assertSame('Категорія', $uk['filters.category_heading']);
        $this->assertSame('НАЗАД', $uk['pagination.previous']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('CATALOG', $en['catalog.hero_watermark']);
        $this->assertSame('All Products', $en['catalog.hero_meta']);
        $this->assertSame('Category', $en['filters.category_heading']);
        $this->assertSame('PREVIOUS', $en['pagination.previous']);
    }
}
