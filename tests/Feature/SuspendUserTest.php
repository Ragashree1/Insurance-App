<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\UserProfileSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuspendUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    const PASS = 'password'; //password

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserProfileSeeder::class);
        $this->seed(UserSeeder::class);
        //logged in as system admin before start of test case
        $this->actingAs(User::where('user_profile_id', '1')->first());
    }

    public function test_system_admin_can_suspend_user(): void
    {
        //get user to be changed
        //note all seeded in user have active status
        $user = User::where('user_profile_id', '!=', '1')->first();

       //call suspend user method
       $this->put("users/" . $user->id . '/' . 'suspend-account');

       //check if database has updated the status of the user to suspended
        $this->assertDatabaseHas('users', [
            'username' => $user->username,
            'status' => 'suspended',
        ]);
    }


}
