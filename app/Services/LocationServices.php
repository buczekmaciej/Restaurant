<?php

namespace App\Services;

use App\Models\Location;

class LocationServices
{
    public static function getCities()
    {
        return Location::distinct()->pluck('address->city AS city');
    }
}
