<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StockClass
{

    public function getParam()
    {
        $rs = new ResultClass();
        try {

            $weathers = WeatherCodes::get();
            $products = Products::where('firm_id', Auth::user()->firm_id)->get();

            $data = [
                "weather" => $weathers,
                "products" => $products
            ];

            $rs->obj = $data;
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        unset($weathers);
        unset($products);
        return $rs;
    }

    public function getWeatherItem()
    {
        $rs = new ResultClass();
        try {

            $code = request()->get('code');

            $rs->obj = WeatherCodes::where('code_start', $code)->select('id', 'description')->first();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        unset($code);
        return $rs;
    }

    public function saveStock($product_id = null, $amount = null, $desc = null)
    {
        $rs = new ResultClass();
        try {

            if ($product_id == null) {
                $product_id = request()->get('product_id');
            }
            
            if ($amount == null) {
                $amount = request()->get('amount');
            }
            
            if ($desc == null) {
                $desc = request()->get('desc');
            }


            $mdl = new DaysStocks();
            $mdl->created_at = Carbon::now();
            $mdl->create_user_id = Auth::user()->id;
            $mdl->updated_at = null;
            $mdl->firm_id = Auth::user()->firm_id;

            $mdl->product_id = $product_id;
            $mdl->amount = $amount;
            $mdl->desc = $desc;

            if ($mdl->save()) {
                $rs->status = true;
            } else {
                $rs->status = false;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        unset($mdl);
        unset($product_id);
        unset($desc);
        unset($amount);
        return $rs;
    }

    public function getStockData()
    {
        $rs = new ResultClass();
        try {

            $date = request()->get('date');
            $date = Carbon::parse($date)->timezone('Europe/Istanbul');
            $rs->obj = DaysStocks::with(['product:id,name'])->where('firm_id', Auth::user()->firm_id)->whereDate('created_at', '=', Carbon::parse($date)->format('Y-m-d'))->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        unset($date);
        return $rs;
    }

    public function stockDelete()
    {
        $rs = new ResultClass();
        try {

            $stock_id = request()->get('stock_id');
            $check = EndOfDays::where('day_stock_id', $stock_id)->count();
            if ($check > 0) {
                $rs->status = false;
                $rs->sub_info = 'usage_rec';
                return $rs;
            }

            if (DB::table('days_stocks')->where('id', $stock_id)->delete()) {
                $rs->status = true;
            } else {
                $rs->status = false;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        unset($stock_id);
        unset($check);
        return $rs;
    }
}
