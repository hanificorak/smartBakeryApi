<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCodes extends Model
{

    public function endOfDays()
    {
        return $this->hasMany(EndOfDays::class, 'weather_code', 'id');
    }

            public function daysInfo()
    {
        return $this->hasMany(DaysInfo::class, 'product_id', 'id');
    }
}
