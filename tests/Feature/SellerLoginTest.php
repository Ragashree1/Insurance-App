<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Database\Seeders\UserProfileSeeder;

class SellerLoginTest extends TestCase
{
    use RefreshDatabase;

    const PASS = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; //password

    protected function setUp(): void
    {

        parent::setUp();
        $this->seed(UserProfileSeeder::class);
    }

    public function test_seller_can_log_in(): void
    {
        $user = User::factory()->create(['user_profile_id' => '3', 'password' => self::PASS]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $this->assertAuthenticated();
        // seller will be redirected to main page (dashboard) upon successful login
        $response->assertRedirect('/dashboard');
    }

    public function test_seller_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create(['user_profile_id' => '3', 'password' => self::PASS]);

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $response->assertSee('These credentials do not match our records.');
    }

    public function test_seller_cannot_login_without_password(): void
    {
        $user = User::factory()->create(['user_profile_id' => '3', 'password' => self::PASS]);

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => '',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $response->assertSee('The password field is required.');

        $this->assertGuest();
    }
}
