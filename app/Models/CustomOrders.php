<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOrders extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function orderProducts()
    {
        return $this->hasMany(CustomOrderProducts::class, 'order_id', 'id');
    }
}
