<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function getNameAttribute()
    {
        return ucfirst($this->attributes['name']);
    }

    public function getDescriptionAttribute()
    {
        return ucfirst($this->attributes['description']);
    }

    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 2, '.', ',');
    }
}
