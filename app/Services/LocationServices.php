<?php

namespace App\Services;

use App\Models\Location;

class LocationServices
{
    public static function getLocations()
    {
        return Location::distinct()->orderBy('city', 'ASC')->pluck('address->city AS city', 'address->street AS street');
    }
}
