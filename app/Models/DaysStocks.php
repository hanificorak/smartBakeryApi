<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DaysStocks extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(DaysStocks::class, 'parent_id');
    }

    public function getRootCreatedAt()
    {
        $current = $this;
        while ($current->parent) {
            $current = $current->parent;
        }
      
        return Carbon::parse($current->created_at)->format('d.m.Y H:i');
    }

   
}
