<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndOfDays extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

     public function weather()
    {
        return $this->belongsTo(WeatherCodes::class, 'weather_code', 'id');
    }
}
