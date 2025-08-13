<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;

class DefinitionsController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new DefinitonsClass();
    }

    public function getProducts()
    {
        try {
           return response()->json($this->class->getProducts());
        } catch (\Throwable $th) {
        }
    }
    public function addProduct()
    {
        try {
           return response()->json($this->class->addProduct());
        } catch (\Throwable $th) {
        }
    }
      public function productDelete()
    {
        try {
           return response()->json($this->class->productDelete());
        } catch (\Throwable $th) {
        }
    }
}
