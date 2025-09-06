<?php

namespace App\Http\Controllers;

use App\Http\Classes\CustomOrderReportClass;

class CustomOrderReportController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new CustomOrderReportClass();
    }

    public function getReportData()
    {
        try {
            return response()->json($this->class->getReportData());
        } catch (\Throwable $th) {
        }
    }

    public function createReportMail()
    {
        try {
            return response()->json($this->class->createReportMail());
        } catch (\Throwable $th) {
        }
    }
}
