<?php

namespace Database\Factories;

use App\Services\AppServices;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => AppServices::generateCode(),
            'total' => fake()->randomFloat(2, 15, 100),
            'address' => json_encode(['street' => fake()->streetAddress(), 'city' => fake()->city(), 'zip' => fake()->postcode()])
        ];
    }
}
