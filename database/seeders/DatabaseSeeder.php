<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Ingredient::factory(50)->create();

        Meal::factory(25)->create()->each(function ($meal) {
            $ingredients = Ingredient::inRandomOrder()->limit(random_int(4, 12))->get();
            $meal->ingredients()->saveMany($ingredients);
        });

        Order::factory(500)->create()->each(function ($order) {
            $meals = Meal::inRandomOrder()->limit(random_int(5, 20))->get();
            $order->meals()->saveMany($meals);
        });

        User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('test'),
            'position' => "owner",
            'phone' => fake()->phoneNumber(),
            'address' => json_encode(['street' => fake()->streetAddress(), 'city' => fake()->city(), 'zip' => fake()->postcode()])
        ]);

        User::factory(100)->create();


        \App\Models\Location::factory(10)->create()->each(function ($location) {
            $employees = User::inRandomOrder()->limit(random_int(9, 11))->get();
            $location->employees()->saveMany($employees);

            $orders = Order::inRandomOrder()->limit(50)->get();
            $location->orders()->saveMany($orders);
        });
    }
}
