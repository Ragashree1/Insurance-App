<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       User::factory()->create([
            'username' => 'admin',
            'email' => 'lucky7@example.com',
            'password' => 'secret',
            'user_profile_id' => 1,
        ]);
        User::factory()->create([
            'username' => 'sam',
            'email' => 'abc@example.com',
            'password' => 'secret',
            'user_profile_id' => 2,
        ]);

        User::factory()->create([
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'password',
            'user_profile_id' => 3,
        ]);

        User::factory()->create([
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => 'password',
            'user_profile_id' => 4,
        ]);
    }
}
