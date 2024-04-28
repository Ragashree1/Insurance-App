<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            // Get a random existing user profile ID
            $randomUserProfileId = UserProfile::inRandomOrder()->first()->id;

        return [
            'username' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'dob' => $this->faker->date('Y-m-d', '2014-12-31'),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => $this->faker->PhoneNumber(),
            'status' => $this->faker->randomElement(['active', 'suspended']),
            'residence_country' => $this->faker->country,
            'nationality' => substr($this->faker->country, 0, 50),
            'password' => 'password',
            'profile_photo_path' => null,
            'user_profile_id' => $randomUserProfileId,
            'created_by' => optional(User::where('user_profile_id', 1)->inRandomOrder()->first())->id,

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    
}
