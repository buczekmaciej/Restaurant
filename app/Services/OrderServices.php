<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Meal;
use App\Models\Order;
use App\Services\LocationServices;
use Illuminate\Database\Eloquent\Collection;

class OrderServices
{
    public static function createOrder($total, $address, $meals, $servingPlace): string
    {
        $order = Order::create([
            'code' => AppServices::generateCode(),
            'total' => $total,
            'address' => json_encode($address),
            'status' => OrderStatus::PREPARING
        ]);

        $order->servingPlace()->associate(LocationServices::getOneLocation($servingPlace));
        $order->save();

        $pickedMeals = Meal::whereIn('name', array_keys(array_change_key_case(($meals))))->get();

        foreach ($pickedMeals as $meal) $order->meals()->attach($meal->id, ['quantity' => $meals[$meal->name]['quantity']]);

        return $order->code;
    }

    public static function checkNewOrders(string $date, string $place): bool
    {
        return LocationServices::getOneLocation($place)->orders()->where('created_at', '>', $date)->count() > 0;
    }

    public static function getPendindOrdersForPlace(string $place): Collection
    {
        return LocationServices::getOneLocation($place)->orders()->where('status', 'preparing')->orderBy('created_at', 'ASC')->get();
    }
}
