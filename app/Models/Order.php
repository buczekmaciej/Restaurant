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

    public function getAddressAttribute()
    {
        return json_decode($this->attributes['address']);
    }

    public function getTotalAttribute()
    {
        return number_format($this->attributes['total'], 2, '.', ',');
    }
}
