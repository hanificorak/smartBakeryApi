<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ReinstallClass
{

    public function start()
    {
        $rs = new ResultClass();
        try {

            DB::beginTransaction();

            DB::table('days_info')->whereDate('created_at',Carbon::now())->delete();
            DB::table('days_stocks')->whereDate('created_at',Carbon::now())->delete();
            DB::table('end_of_days')->whereDate('created_at',Carbon::now())->delete();
            DB::table('holidays')->whereDate('created_at',Carbon::now())->delete();
            DB::table('freezers')->whereDate('created_at',Carbon::now())->delete();
            DB::table('custom_orders')->whereDate('created_at',Carbon::now())->delete();


            DB::commit();
            $rs->status = true;
        } catch (\Throwable $th){
            DB::rollBack();
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        return $rs;
    }
}
