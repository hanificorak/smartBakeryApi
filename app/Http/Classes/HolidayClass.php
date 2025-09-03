<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysInfo;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Holidays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HolidayClass
{

    public function getData()
    {
        $rs = new ResultClass();
        try {

            $rs->status = true;
            $rs->obj = Holidays::where('firm_id', Auth::user()->firm_id)->orderBy('date', 'asc')->get();
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function add()
    {
        $rs = new ResultClass();
        try {


            $title = request()->get('title');
            $date = request()->get('date');

            $mdl = new Holidays();
            $mdl->create_user_id = Auth::user()->id;
            $mdl->firm_id = Auth::user()->firm_id;
            $mdl->title = $title;
            $mdl->date = Carbon::parse($date);


            if ($mdl->save()) {
                $rs->status = true;
            } else {
                $rs->status = false;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function delete()
    {
        $rs = new ResultClass();
        try {


            $id = request()->get('id');

            if (DB::table("holidays")->where('id', $id)->delete()) {
                $rs->status = true;
            } else {
                $rs->status = false;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
