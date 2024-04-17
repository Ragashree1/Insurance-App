<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginOutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    const PASS = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; //password

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserProfileSeeder::class);
    }

    public function test_system_admin_can_log_out(): void
    {
        $user = User::factory()->create(['user_profile_id' => '1', 'password' => self::PASS]);
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        //system admin will be redirected to login page after logout
        $response->assertRedirect('/');
    }

    public function test_real_estate_agent_can_log_out(): void
    {
        $user = User::factory()->create(['user_profile_id' => '3', 'password' => self::PASS]);
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_seller_can_log_out(): void
    {
        $user = User::factory()->create(['user_profile_id' => '3', 'password' => self::PASS]);
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_buyer_can_log_out(): void
    {
        $user = User::factory()->create(['user_profile_id' => '4', 'password' => self::PASS]);
        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

}
