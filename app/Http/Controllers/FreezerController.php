<?php

namespace App\Http\Controllers;

use App\Http\Classes\FreezerClass;

class FreezerController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new FreezerClass();
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

    public function delete()
    {
        try {
            return response()->json($this->class->delete());
        } catch (\Throwable $th) {
        }
    }

    public function createReport()
    {
        try {
            return response()->json($this->class->createReport());
        } catch (\Throwable $th) {
        }
    }
}
