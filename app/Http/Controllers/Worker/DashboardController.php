<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Services\AppServices;
use App\Services\LocationServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('views.worker.dashboard', ['data' => AppServices::getDashboardData(), 'locations' => LocationServices::getIncomeStatistics()]);
    }
}
