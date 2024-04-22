<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use Database\Seeders\UserProfileSeeder;

class SystemAdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {

        parent::setUp();
        $this->seed(UserProfileSeeder::class);
    }

    public function test_system_admin_can_log_in(): void
    {
        $user = User::factory()->create(['user_profile_id' => '1', 'password' => 'password']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $this->assertAuthenticated();
        //system admin will be redirected to main page (dashboard) upon successful login
        $response->assertRedirect('/dashboard');
    }

    public function test_system_admin_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create(['user_profile_id' => '1', 'password' => 'password']);

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $response->assertSee('These credentials do not match our records.');
    }

    public function test_system_admin_cannot_login_without_password(): void
    {
        $user = User::factory()->create(['user_profile_id' => '1', 'password' => 'password']);

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => '',
            'user_profile_id' => $user->user_profile_id,
        ]);

        $response->assertSee('The password field is required.');

        $this->assertGuest();
    }
}
