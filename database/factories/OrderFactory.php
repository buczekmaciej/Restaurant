<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
        return [
            'code' => $this->generateCode(),
            'total' => fake()->randomFloat(2, 15, 100),
            'address' => json_encode(['street' => fake()->streetAddress(), 'city' => fake()->city(), 'zip' => fake()->postcode()])
        ];
    }
}
