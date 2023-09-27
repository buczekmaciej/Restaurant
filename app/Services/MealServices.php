<?php

namespace App\Services;

use App\Models\Meal;

class MealServices
{
    public static function getMenu()
    {
        return Meal::with('ingredients')->orderBy('meals.name', 'ASC')->get();
    }
}
