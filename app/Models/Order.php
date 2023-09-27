<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'total',
        'address',
        'status'
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('quantity');
    }

    public function servingPlace()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function getAddress()
    {
        return $this->formatAddress($this->address);
    }

    public function getServingPlaceAddress()
    {
        return $this->formatAddress($this->servingPlace()->first()->address);
    }

    private function formatAddress(string $address)
    {
        $address = json_decode($address);

        return "{$address->street}, {$address->city} {$address->zip}";
    }
}
