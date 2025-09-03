<?php

namespace App\Http\Controllers;

use App\Http\Classes\HolidayClass;

class HolidayController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new HolidayClass();
    }

    public function getData()
    {
        try {
            return response()->json($this->class->getData());
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
