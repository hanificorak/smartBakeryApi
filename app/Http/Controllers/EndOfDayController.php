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
            return response()->json($this->class->addEndOfData());
        } catch (\Throwable $th) {
        }
    }

    public function endOfDataCheck()
    {
        try {
            return response()->json($this->class->endOfDataCheck());
        } catch (\Throwable $th) {
        }
    }

    public function getEndOfData()
    {
        try {
            return response()->json($this->class->getEndOfData());
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
