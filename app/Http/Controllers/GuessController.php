<?php

namespace App\Http\Controllers;

use App\Http\Classes\GuessClass;

class GuessController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new GuessClass();
    }

    public function getData()
    {
        try {
            return response()->json($this->class->getData());
        } catch (\Throwable $th) {
        }
    }

    public function totalGuessPdfMail()
    {
        try {
            return response()->json($this->class->totalGuessPdfMail());
        } catch (\Throwable $th) {
        }
    }

}
