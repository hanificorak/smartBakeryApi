<?php

namespace App\Http\Controllers;

use App\Http\Classes\CompanyClass;

class CompanyController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new CompanyClass();
    }

    public function getData()
    {
        try {
            return response()->json($this->class->getData());
        } catch (\Throwable $th) {
        }
    }

       public function save()
    {
        try {
            return response()->json($this->class->save());
        } catch (\Throwable $th) {
        }
    }
}
