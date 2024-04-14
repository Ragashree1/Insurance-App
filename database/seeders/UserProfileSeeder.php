<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfile::factory()->create([
            'name' => 'System Admin',
            'description' => 'Manages users and user profiles',
            'status' => 'active',
        ]);

        UserProfile::factory()->create([
            'name' => 'Real Estate Agent',
            'description' => 'Manages property listings',
            'status' => 'active',
        ]);

        UserProfile::factory()->create([
            'name' => 'Seller',
            'description' => 'Sells properties',
            'status' => 'active',
        ]);

        UserProfile::factory()->create([
            'name' => 'Buyer',
            'description' => 'Buys properties',
            'status' => 'active',
        ]);
    }
}
