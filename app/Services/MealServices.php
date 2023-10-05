<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;

class MealServices
{
    public static function getMenu(): Collection
    {
        return Meal::with('ingredients')->orderBy('meals.name', 'ASC')->get();
    }

    public static function calcTotal(array $order): int
    {
        $total = 0;

        foreach ($order as $meal) $total += ($meal['price'] * $meal['quantity']);

        return $total;
    }

    public static function createMeal($data, $ingredients): void
    {
        $meal = Meal::create($data);
        $meal->ingredients()->attach(Ingredient::whereIn('name', $ingredients)->pluck('id'));
    }
}
