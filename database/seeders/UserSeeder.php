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
            'name' => 'admin',
            'email' => 'lucky7@example.com',
            'password' => Hash::make('secret'),
            'profile_id' => 1,
        ]);
        User::factory()->count(5)->create();
    }
}
