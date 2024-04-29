<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyListing>
 */
class PropertyListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['HDB', 'Condo', 'Bungalow']),
            'title' => $this->faker->sentence,
            'num_bedroom' => $this->faker->numberBetween(1, 5),
            'num_bathroom' => $this->faker->numberBetween(1, 3),
            'area' => $this->faker->numberBetween(500, 2000),
            'sale_price' => $this->faker->numberBetween(100000, 1000000),
            'location' => $this->faker->address,
            'description' => $this->faker->paragraph(5),
            'create_by' => User::where('user_profile_id', 2)->inRandomOrder()->first()->id,
            'seller_id' => User::where('user_profile_id', 3)->inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['new', 'sold']),
            'num_views' => $this->faker->numberBetween(0, 1000),
            'num_shortlist' => $this->faker->numberBetween(0, 100),
        ];
    }
}
