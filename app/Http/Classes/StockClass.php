<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysStocks;
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
            $products = Products::get();

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
        return $rs;
    }

    public function saveStock()
    {
        $rs = new ResultClass();
        try {

            $product_id = request()->get('product_id');
            $weather_id = request()->get('weather_id');
            $amount = request()->get('amount');
            $desc = request()->get('desc');

            $mdl = new DaysStocks();
            $mdl->created_at = Carbon::now();
            $mdl->create_user_id = Auth::user()->id;
            $mdl->updated_at = null;

            $mdl->product_id = $product_id;
            $mdl->weather_id = $weather_id;
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
        return $rs;
    }

    public function getStockData()
    {
        $rs = new ResultClass();
        try {


            $rs->obj = DaysStocks::with(['product:id,name'])->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
