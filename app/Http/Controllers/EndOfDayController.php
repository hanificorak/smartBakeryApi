<?php

namespace App\Http\Controllers;

use App\Http\Classes\EndOfDayClass;

class EndOfDayController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new EndOfDayClass();
    }

    public function getEndOfListData()
    {
        try {
            return response()->json($this->class->getEndOfListData());
        } catch (\Throwable $th) {
        }
    }

    public function addEndOfData()
    {
        try {
            return response()->json($this->class->getEndOfListData());
        } catch (\Throwable $th) {
        }
    }
}
