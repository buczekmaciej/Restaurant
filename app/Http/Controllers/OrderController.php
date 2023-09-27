<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function track(Order $order = null)
    {
        return view('views.orders.tracker')->with('order', $order);
    }
}
