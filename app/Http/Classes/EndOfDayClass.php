<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysInfo;
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


            $data = DaysStocks::with(['product:id,name'])->where('firm_id', Auth::user()->firm_id)->whereDate('created_at', '=', Carbon::now()->addDay(0))->get();
            foreach ($data as $key => $value) {
                $data[$key]->parentdate = $value->getRootCreatedAt();
              
            }

            $rs->obj = $data;
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
                $current = $value['current']; // bugün satılan miktar -- bugün elinde kalan ürün sayısı
                $product_id = $value['product_id']; // ürün bilgisi
                $amount = $value['amount']; // Bugün üretilen adet bilgisi

                $mdl = new EndOfDays();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->created_at = Carbon::now();
                $mdl->updated_at = null;

                $mdl->firm_id = Auth::user()->firm_id;
                $mdl->product_id = $product_id;
                $mdl->current = $current;
                $mdl->amount = $amount;
                $mdl->day_stock_id = $id;
                $mdl->weather_code = $weather_temp_code;
                $mdl->temperature = $weather_temp;
                $mdl->save();

                $mdl_day = null;

                if ($value['ert_status'] == true) {

                    if($current == 0){
                        $current = $amount;
                    }

                    $mdl_day = new DaysStocks();
                    $mdl_day->created_at = Carbon::now()->addDay(1);
                    $mdl_day->create_user_id = Auth::user()->id;
                    $mdl_day->updated_at = null;
                    $mdl_day->firm_id = Auth::user()->firm_id;
                    $mdl_day->product_id = $product_id;
                    $mdl_day->amount = $current;
                    $mdl_day->desc = "Ertesi günden aktarılan kayıt.";
                    $mdl_day->parent_id = $id;
                    $mdl_day->save();
                }

                $rem_count = $current;

                if ($mdl_day != null) {
                    $rem_count = $rem_count - $mdl_day->amount;
                }

                $days = new DaysInfo();
                $days->created_at = Carbon::now();
                $days->create_user_id = Auth::user()->id;
                $days->product_id = $product_id;
                $days->amount = $amount;
                $days->sales_amount = $amount - $current;
                $days->remove_amount = $rem_count;
                $days->ert_count = ($mdl_day == null ? 0 : $mdl_day->amount);
                $days->weather_code = $weather_temp_code;
                $days->temperature = $weather_temp;
                $days->end_of_id = $mdl->id;
                $days->firm_id = $mdl->firm_id;
                $days->save();
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

            $check = EndOfDays::whereDate('created_at', Carbon::now())->where('firm_id', Auth::user()->firm_id)->count();

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

            $active_lang = 'de';

            $data = DaysInfo::with('product')->with('weather')->where('firm_id', Auth::user()->firm_id)->whereDate('created_at', '=', Carbon::now()->addDay(0))->get();

            foreach ($data as $key => $value) {
                $data[$key]->weather->description = $value->weather->{$active_lang} ?? $value->description;
            }
            // $data = EndOfDays::with('product')->where('firm_id', Auth::user()->firm_id)->with('weather')->whereDate('created_at', '=', Carbon::now())->get();

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
        DB::beginTransaction();
        try {

            $id = request()->get('id');

            $item = EndOfDays::where('id', $id)->first();
            $day_item = DaysStocks::where('parent_id', $item->day_stock_id)->first();

            if ($day_item != null) {
                DB::table('days_stocks')->where('parent_id', $item->day_stock_id)->delete();
            }

            if (DB::table('end_of_days')->where('id', $id)->delete() && DB::table('days_info')->where('end_of_id', $id)->delete()) {
                DB::commit();

                $rs->status = true;
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
