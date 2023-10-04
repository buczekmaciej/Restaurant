<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function working(): View
    {
        return view('views.worker.working', ['orders' => OrderServices::getPendindOrdersForPlace((auth()->user()->workplace->id * 5 + 3) * 8)]);
    }

    public function view(): View
    {
        return view('views.worker.orders.view', ['orders' => Order::paginate(100)]);
    }
}
