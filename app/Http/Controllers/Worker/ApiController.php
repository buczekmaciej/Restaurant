<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Services\OrderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function checkNewOrders(Request $request): JsonResponse
    {
        return response()->json(OrderServices::checkNewOrders($request->get('date'), $request->get('place')));
    }
}
