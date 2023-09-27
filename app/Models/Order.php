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
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class);
    }

    public function servingPlace()
    {
        return $this->belongsTo(Location::class);
    }
}
