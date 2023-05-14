<?php

namespace Tests\Unit;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled(): void
    {
        if (Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is enabled.');

            return;
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
        // dd($response);
    }

    public function test_users_can_not_register_with_empty_name(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);
    }

    public function test_users_can_not_register_with_empty_email(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }

    public function test_users_can_not_register_with_empty_password(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);
    }

    public function test_users_can_not_register_with_empty_confirm_password(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => '',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field confirmation does not match.'
        ]);
    }

    public function test_users_can_not_register_with_empty_captcha(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '',
        ]);

        $response->assertSessionHasErrors([
            'g-recaptcha-response' => 'The g-recaptcha-response field is required.'
        ]);
    }

    public function test_users_can_not_register_with_incorect_confirm_password(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password1',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field confirmation does not match.'
        ]);
    }

    public function test_users_can_not_register_with_a_registered_email(): void
    {
        if (! Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');

            return;
        }
        $user = User::factory()->create();

        $response = $this->post('/register', [
            'name' => 'Test Case',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken.'
        ]);
    }
}
