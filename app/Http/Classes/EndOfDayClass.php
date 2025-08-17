<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EndOfDayClass
{
    public function getEndOfListData()
    {
        $rs = new ResultClass();
        try {

            $rs->obj = DaysStocks::with(['product:id,name'])->whereDate('created_at', '=', '2025-08-17')->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function addEndOfData()
    {
        $rs = new ResultClass();
        try {

            $data = request()->get('data');
            $weather_temp = request()->get('weather_temp');
            $weather_temp_code = request()->get('weather_temp_code');

            foreach ($data as $key => $value) {
                $id = $value['id']; // day_stock_id
                $current = $value['current']; // bugün satılan miktar
                $product_id = $value['product_id']; // ürün bilgisi
                $amount = $value['amount']; // Bugün üretilen adet bilgisi

                $mdl = new EndOfDays();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->created_at = Carbon::now();
                $mdl->updated_at = null;

                $mdl->product_id = $product_id;
                $mdl->current = $current;
                $mdl->amount = $amount;
                $mdl->day_stock_id = $id;
                $mdl->weather_code = $weather_temp_code;
                $mdl->temperature = $weather_temp;
                $mdl->save();
            }

            $rs->status = true;
            $rs->message = "ok";
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function endOfDataCheck()
    {
        $rs = new ResultClass();
        try {

            $check = EndOfDays::whereDate('created_at', Carbon::now())->count();

            if ($check > 0) {
                $rs->status = false;
            } else {
                $rs->status = true;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function getEndOfData()
    {
        $rs = new ResultClass();
        try {

        $data = EndOfDays::with('product')->with('weather')->whereDate('created_at','=',Carbon::now())->get();

        $rs->status = true;
        $rs->obj = $data;
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

            if(DB::table('end_of_days')->where('id',$id)->delete()){
                $rs->status = true;
            }

        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
