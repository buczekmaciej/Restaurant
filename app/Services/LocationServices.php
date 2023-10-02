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

    public static function getIncomeStatistics(): array
    {
        $results = [];
        $locations = Location::orderBy('address->city', 'ASC')->get();

        foreach ($locations as $location) {
            $total = $location->orders()->where('created_at', '>', now()->startOfMonth())->sum('total');
            $profit = $total - $location->orders()->where([['created_at', '>', now()->startOfMonth()->subMonth()], ['created_at', '<', now()->startOfMonth()->subSecond()]])->sum('total');
            $results[] = [
                'address' => $location->address->street . ", " . $location->address->city,
                'employees' => $location->employees()->count(),
                'income' => $total,
                'profit' => $profit,
                'outcome' => $profit > 0 ? 'text-green-500' : ($profit < 0 ? 'text-red-500' : 'text-white')
            ];
        }

        return $results;
    }
}
