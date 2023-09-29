<?php

namespace App\Services;

use App\Models\Location;

class LocationServices
{
    public static function getLocations(): array
    {
        return Location::distinct()->orderBy('address->city', 'ASC')->pluck('address', 'id')->toArray();
    }

    public static function getOneLocation($modifiedID): Location
    {
        return Location::where('id', (($modifiedID / 8) - 3) / 5)->first();
    }
}
