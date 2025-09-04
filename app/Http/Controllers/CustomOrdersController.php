<?php

namespace App\Http\Controllers;

use App\Http\Classes\CustomOrdersClass;

class CustomOrdersController
{
    public $class = null;
    public function __construct()
    {
        $this->class = new CustomOrdersClass();
    }

    public function getCustomOrders()
    {
        try {
            return response()->json($this->class->getCustomOrders());
        } catch (\Throwable $th) {
        }
    }

    public function add()
    {
        try {
            return response()->json($this->class->add());
        } catch (\Throwable $th) {
        }
    }

    public function delete()
    {
        try {
            return response()->json($this->class->delete());
        } catch (\Throwable $th) {
        }
    }
}
