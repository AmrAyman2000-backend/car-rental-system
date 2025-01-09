<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    const PATH = "images/cars";
    protected $fillable = ["name","type","price_per_day","availability_status","image"];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
