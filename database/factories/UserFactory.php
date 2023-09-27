<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private function generateCode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = "";
        $charactersLength = strlen($characters);

        for ($i = 0; $i < 35; $i++) $code .= $characters[random_int(0, $charactersLength - 1)];

        return $code;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = ["employee", "manager"];

        return [
            'code' => $this->generateCode(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'position' => $positions[array_rand($positions)],
            'phone' => fake()->phoneNumber(),
            'address' => json_encode(['street' => fake()->streetAddress(), 'city' => fake()->city(), 'zip' => fake()->postcode()])
        ];
    }
}