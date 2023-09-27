<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LocationServices;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function homepage()
    {
        return view("views.homepage")->with('locations', LocationServices::getLocations());
    }

    public function menu()
    {
        return view('views.menu');
    }
}
