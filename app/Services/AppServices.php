<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Location;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;

class AppServices
{
    public static function generateCode(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = "";
        $charactersLength = strlen($characters);

        for ($i = 0; $i < 35; $i++) $code .= $characters[random_int(0, $charactersLength - 1)];

        return $code;
    }

    public static function getDashboardData(): array
    {
        return [
            'Monthly income' => "$" . Order::where('created_at', '>', now()->startOfMonth())->sum('total'),
            'Monthly orders' => Order::where('created_at', '>', now()->startOfMonth())->count(),
            'Employees' => User::count(),
            'Existing places' => Location::count(),
            'Menu positions' => Meal::count(),
            'Ingredients used' => Ingredient::count()
        ];
    }
}
