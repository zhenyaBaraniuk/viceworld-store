<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('Додати в кошик', $uk['product.add_to_cart']);
        $this->assertSame('Оберіть розмір', $uk['product.select_size']);
        $this->assertSame('Опис', $uk['product.description_heading']);
        $this->assertSame('▶ ВІДЕО', $uk['product.video_badge']);
        $this->assertSame('Доповни образ', $uk['product.complete_the_look']);
        $this->assertSame('Головна', $uk['common.breadcrumb_home']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Add to Cart', $en['product.add_to_cart']);
        $this->assertSame('Select size', $en['product.select_size']);
        $this->assertSame('Description', $en['product.description_heading']);
        $this->assertSame('▶ VIDEO', $en['product.video_badge']);
        $this->assertSame('Complete the Look', $en['product.complete_the_look']);
        $this->assertSame('Home', $en['common.breadcrumb_home']);
    }
}
