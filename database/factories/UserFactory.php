<?php

namespace Database\Factories;

use App\Services\AppServices;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
        $positions = ["employee", "manager"];

        return [
            'code' => AppServices::generateCode(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'position' => $positions[array_rand($positions)],
            'phone' => fake()->phoneNumber(),
            'address' => json_encode(['street' => fake()->streetAddress(), 'city' => fake()->city(), 'zip' => fake()->postcode()])
        ];
    }
}
