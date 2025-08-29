<?php

namespace App\Http\Controllers;

use App\Http\Classes\ReinstallClass;

class ReinstallController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new ReinstallClass();
    }

    public function start()
    {
        try {
            return response()->json($this->class->start());
        } catch (\Throwable $th) {
        }
    }


}
