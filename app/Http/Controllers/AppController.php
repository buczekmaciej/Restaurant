<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LocationServices;
use App\Services\MealServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function homepage(): View
    {
        return view("views.homepage")->with('locations', LocationServices::getLocations());
    }

    public function menu(): View
    {
        return view('views.menu')->with('menu', MealServices::getMenu());
    }
}
