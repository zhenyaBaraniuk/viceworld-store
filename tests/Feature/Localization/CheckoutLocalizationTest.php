<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_page_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('Оформити замовлення', $uk['checkout.place_order']);
        $this->assertSame('Кур\'єрська доставка', $uk['checkout.delivery_courier']);
        $this->assertSame('Самовивіз з магазину', $uk['checkout.delivery_pickup']);
        $this->assertSame('Підсумок замовлення', $uk['checkout.order_summary']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Place order', $en['checkout.place_order']);
        $this->assertSame('Courier Delivery', $en['checkout.delivery_courier']);
        $this->assertSame('Pickup in Store', $en['checkout.delivery_pickup']);
        $this->assertSame('Order Summary', $en['checkout.order_summary']);
    }
}
