<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysInfo;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LastStockClass
{
    public function getData()
    {
        $rs = new ResultClass();
        try {


            $rs->status = true;
            $rs->obj = DaysStocks::with('product')->where('firm_id', Auth::user()->firm_id)->whereDate('created_at', '=', Carbon::now()->addDay(-1))->get();
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function save()
    {
        $rs = new ResultClass();
        try {


            $datas = request()->get('data');
            $day_stock = new StockClass();
            foreach ($datas as $key => $value) {
                $current  = $value['current']; //Seçilen miktar
                $product = $value['id'];
                $day_stock->saveStock($product,$current);
            }

            $rs->status = true;
            
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
