<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('До покупок', $uk['hero.cta']);
        $this->assertSame('Том', $uk['category_tiles.volume_prefix']);
        $this->assertSame('Новинки', $uk['home.new_arrivals_title']);
        $this->assertSame('Глобальні хаби / Локації магазинів', $uk['store_locations.stores_title']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Shop now', $en['hero.cta']);
        $this->assertSame('Volume', $en['category_tiles.volume_prefix']);
        $this->assertSame('New Arrivals', $en['home.new_arrivals_title']);
        $this->assertSame('Global Hubs / Store Locations', $en['store_locations.stores_title']);
    }
}
