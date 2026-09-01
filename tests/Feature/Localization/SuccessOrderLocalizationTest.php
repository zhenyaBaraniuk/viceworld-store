<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuccessOrderLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_order_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('ПІДТВЕРДЖЕНО', $uk['success.confirmed']);
        $this->assertSame('Купувати знову', $uk['success.shop_again']);
        $this->assertSame('Відстежити посилку', $uk['success.track_parcel']);
        $this->assertSame('Вікно доставки', $uk['success.delivery_window_label']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('CONFIRMED', $en['success.confirmed']);
        $this->assertSame('Shop Again', $en['success.shop_again']);
        $this->assertSame('Track Parcel', $en['success.track_parcel']);
        $this->assertSame('Delivery Window', $en['success.delivery_window_label']);
    }
}
