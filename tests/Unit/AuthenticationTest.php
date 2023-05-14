<?php

namespace Tests\Unit;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen_with_correct_credential(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_empty_email(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }

    public function test_users_can_not_authenticate_with_empty_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_email(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_unregistered_email(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => 'isitintoilet@ggmail.com',
            'password' => 'password',
        ]);

        // dd($response);

        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_after_throttle(): void
    {
        //create a user with known password
        $user = User::factory()->create();

        //then make 5 post request to the authentication route
        for ($i = 0; $i < 5; ++$i) {
                $response = $this->post('/login', [
                        'email' => $user->email,
                        'password' => 'wrong-password',
                    ]);

            $response->assertFound();
        }

        //then on the 6th you would expect to see the throtteler to stop the request
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertTooManyRequests();
    }

    public function test_captcha_is_not_required_until_3rd_attempt(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 2; ++$i) {
            $response = $this->post('/login', [
                    'email' => $user->email,
                    'password' => 'wrong-password',
                ]);
        $response->assertSessionDoesntHaveErrors(['g-recaptcha-response']);
        }
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['g-recaptcha-response']);
    }

    public function test_users_can_not_authenticate_with_invalid_captcha(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 3; ++$i) {
            $response = $this->post('/login', [
                    'email' => $user->email,
                    'password' => 'wrong-password',
                ]);
        }

        $response->assertInvalid(['g-recaptcha-response']);
    }

    public function test_users_can_not_authenticate_with_valid_captcha(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 3; ++$i) {
            $this->post('/login', [
                    'email' => $user->email,
                    'password' => 'wrong-password',
                ]);
        }

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'g-recaptcha-response' => '03AL8dmw_Pp5Hv7KP3IPIYHTQ_C014u6hCHPU9VYWYIM2KdTJvuvyR9Mm_t6-Cze7COksYEKuxw5NHEM73i_HR5zsOwaqw7wYUb8Igg7xPjK_CJe6i38_2S9arBWIFAXLIMKjUO_gV-vFY3Z9qUhAnTTYRWPOsSFwlZh9OF_l8wEZdcsjg7UT-yB0FwFrODthKLyBP-Y6M7neFCOBJ7TL1M6qr54DOwnQD9Gn_MJBHmt-nI5QM-Pvp1SXuSKi6SMAyZ5KFDL2GGe17oIz1jHo1m5mluRzEtbHdCpp71ECtRawBCmsxKGc-iPnkJKKy9jMCujVU0qnS7LDM8EiwIbfg6YhZdml-LExK6UQHkJsVN-75ceBzYBc64Z4GJoOUXEswrqF3YRgosxR9GvToGxagEE7sb_DtE_gcIB0kL5UMRt5-PrTJSfH-ta5su8zxIUKwreC5-zDkAjSMLm5Nnpm7g5SlD9CCwHZLx3d6VUUMbvH5-b9UOS6iA4xRJ7X9CMxbjSjOn_tJP6pFFt_b4mjIVNRYhRRb_ldVu3Ldejp61TMsgqZPBVwi3Ws',
        ]);


        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
