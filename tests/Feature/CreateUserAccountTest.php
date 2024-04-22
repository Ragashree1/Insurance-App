<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\UserProfileSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserAccountTest extends TestCase
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

    public function test_system_admin_can_create_user_account(): void
    {
        $user = User::factory()->create(['user_profile_id' => '1', 'password' => self::PASS]);
        $this->actingAs($user);

        $response = $this->post('users', [
            'username' => 'abcde',
            'first_name' => 'John',
            'last_name' => 'Lee',
            'email' => 'abcd@example.com',
            'contact' => '12345678',
            'dob' => Carbon::createFromFormat('Y-m-d', '2010-10-10'),
        ]);

        // dd($response);
        $this->assertDatabaseHas('users', [
            'username' => 'abcde'
        ]);
    }


}
