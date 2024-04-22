<?php

namespace Database\Seeders;

use App\Models\PropertyListing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertyListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyListing::factory()->times(5)->create([
            'create_by' => 2,
        ]);
    }
}
