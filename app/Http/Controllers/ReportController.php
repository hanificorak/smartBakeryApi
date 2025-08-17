<?php

namespace App\Http\Controllers;

use App\Http\Classes\ReportClass;
use App\Http\Classes\Tools\ResultClass;
use App\Models\EndOfDays;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function createReport()
    {
        try {
            return response()->json($this->class->reportSend());
        } catch (\Throwable $th) {
        }
    }
}
