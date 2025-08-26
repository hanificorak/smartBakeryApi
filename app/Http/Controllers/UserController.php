<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;
use App\Http\Classes\UserClass;

class UserController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new UserClass();
    }

    public function addUser()
    {
        try {
           return response()->json($this->class->addUser());
        } catch (\Throwable $th) {
        }
    }

    public function getUsers()
    {
        try {
           return response()->json($this->class->getUsers());
        } catch (\Throwable $th) {
        }
    }

   

}
