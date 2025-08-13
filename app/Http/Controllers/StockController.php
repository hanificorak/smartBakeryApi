<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;

class StockController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new StockClass();
    }

    public function getParam()
    {
        try {
           return response()->json($this->class->getParam());
        } catch (\Throwable $th) {
        }
    }

    public function getWeatherItem()
    {
        try {
           return response()->json($this->class->getWeatherItem());
        } catch (\Throwable $th) {
        }
    }

    public function saveStock()
    {
        try {
           return response()->json($this->class->saveStock());
        } catch (\Throwable $th) {
        }
    }

    public function getStockData()
    {
        try {
           return response()->json($this->class->getStockData());
        } catch (\Throwable $th) {
        }
    }

}
