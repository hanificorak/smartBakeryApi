<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function daysStocks()
    {
        return $this->hasMany(DaysStocks::class, 'product_id', 'id');
    }

    public function endOfDays()
    {
        return $this->hasMany(EndOfDays::class, 'product_id', 'id');
    }

    public function daysInfo()
    {
        return $this->hasMany(DaysInfo::class, 'product_id', 'id');
    }

    public function customOrders()
    {
        return $this->hasMany(CustomOrders::class, 'product_id', 'id');
    }
}
