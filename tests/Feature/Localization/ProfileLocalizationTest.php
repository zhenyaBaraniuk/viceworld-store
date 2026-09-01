<?php

namespace Tests\Feature\Localization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_pages_copy_differs_by_locale(): void
    {
        $uk = $this->inertiaProps($this->get('/uk/search'))['translations'];

        $this->assertSame('Профіль', $uk['profile.nav_profile']);
        $this->assertSame('Вийти', $uk['profile.nav_logout']);
        $this->assertSame('Електронна пошта', $uk['profile.email_label']);
        $this->assertSame('Редагувати профіль', $uk['profile.edit_profile_button']);
        $this->assertSame('Зберегти пароль', $uk['profile.save_password_button']);
        $this->assertSame('Замовлення', $uk['profile.order_table_order_header']);
        $this->assertSame('Доставлено', $uk['profile.order_status_delivered']);

        $en = $this->inertiaProps($this->get('/en/search'))['translations'];

        $this->assertSame('Profile', $en['profile.nav_profile']);
        $this->assertSame('Log Out', $en['profile.nav_logout']);
        $this->assertSame('Email Address', $en['profile.email_label']);
        $this->assertSame('EDIT PROFILE', $en['profile.edit_profile_button']);
        $this->assertSame('Save Password', $en['profile.save_password_button']);
        $this->assertSame('ORDER', $en['profile.order_table_order_header']);
        $this->assertSame('Delivered', $en['profile.order_status_delivered']);
    }
}
