<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Meal;
use App\Models\Order;
use App\Services\LocationServices;

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
}
