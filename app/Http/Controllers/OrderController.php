<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\LocationServices;
use App\Services\MealServices;
use App\Services\OrderServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function track(Order $order = null): View
    {
        return view('views.orders.tracker')->with('order', $order);
    }

    public function create(Request $request): View
    {
        return view('views.orders.create', ['address' => $request->post('address'), 'meals' => MealServices::getMenu(), 'places' => LocationServices::getLocations()]);
    }

    public function summary(Request $request): View|RedirectResponse
    {
        $meals = array_filter($request->post('meals'), fn ($item) => $item['quantity'] !== null);
        $place = LocationServices::getOneLocation($request->post('serving-place'));

        return view('views.orders.summary', ['total' => MealServices::calcTotal($meals), 'meals' => $meals, 'address' => $request->post('address'), 'place' => ['value' => $request->post('serving-place'), 'address' => $place->address->street . ", " . $place->address->city]]);
    }

    public function save(Request $request): RedirectResponse
    {
        $code = OrderServices::createOrder($request->post('total'), $request->post('address'), $request->post('meals'), intval($request->post('serving-place')['value']));

        return redirect()->route('order.track')->with('code', $code);
    }
}
