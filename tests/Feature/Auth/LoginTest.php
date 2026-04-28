<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_screen(): void
    {
        $subdomain = config('app.subdomain');

        $domain = config('app.domain');

        $response = $this->get("http://{$subdomain}.{$domain}/login");

        $response->assertOk();
    }

    public function test_user_can_authenticate_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $subdomain = config('app.subdomain');

        $domain = config('app.domain');

        $response = $this->post("http://{$subdomain}.{$domain}/login", [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $subdomain = config('app.subdomain');

        $domain = config('app.domain');

        $response = $this->from("http://{$subdomain}.{$domain}/login")->post("http://{$subdomain}.{$domain}/login", [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect("http://{$subdomain}.{$domain}/login");
        $response->assertSessionHasErrors('email');
    }
}
