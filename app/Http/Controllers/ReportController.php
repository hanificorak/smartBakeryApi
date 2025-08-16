<?php

namespace App\Http\Controllers;

use App\Http\Classes\ReportClass;

class ReportController
{

    public $class = null;
    public function __construct()
    {
        $this->class = new ReportClass();
    }
    
          public function getReportData()
    {
        try {
            return response()->json($this->class->getReportData());
        } catch (\Throwable $th) {
        }
    }
  
}
