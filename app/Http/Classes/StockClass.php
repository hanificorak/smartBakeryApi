<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysInfo;
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

            $active_lang = request()->get('lang');
            if ($active_lang == null) {
                $active_lang = 'de';
            }

            $weathers = WeatherCodes::get();
            foreach ($weathers as $key => $value) {
                $weathers[$key]->description = $value->{$active_lang} ?? $value->description;
            }
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

            $active_lang = request()->get('lang');
            if ($active_lang == null) {
                $active_lang = 'de';
            }


            $code = request()->get('code');

            $items = WeatherCodes::where('code_start', $code)->select('*')->first();
            if ($items) {
                $items->description = $items->{$active_lang} ?? $items->description;
            }

            $rs->obj = $items;
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


            $check = DaysStocks::where('product_id', $product_id)
                ->where('firm_id', Auth::user()->firm_id)
                ->whereDate('created_at', Carbon::now())
                ->where(function ($q) {
                    $q->whereNull('desc') // desc NULL ise
                    ->orWhere('desc', '!=', 'Ertesi günden aktarılan kayıt.'); // veya farklı bir değer ise
                })
                ->exists();
            if ($check) {
                $rs->status = false;
                $rs->sub_info = "rec_mev";
                return $rs;
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

    public function allProducts()
    {
        $rs = new ResultClass();
        try {


            $all_pr = Products::where('firm_id',Auth::user()->firm_id)->get();
            foreach ($all_pr as $key => $pr) {
                $last_item = DaysInfo::where('product_id', $pr->id)
                    ->whereDate('created_at', Carbon::now()->subDay()) // addDay(-1) yerine subDay()
                    ->first();


                $all_pr[$key]->quantity = 0;
                if ($last_item) {
                    $all_pr[$key]->last_quantity = $last_item->sales_amount;
                }else{
                    $all_pr[$key]->last_quantity = 0;
                }
            }

            $rs->obj = $all_pr;
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }


        return $rs;
    }

    public function allProductsSave()
    {
        $rs = new ResultClass();
        try {

            $datas = request()->get('data');

            foreach ($datas as $key => $value) {
                $product_id = $value['id'];
                $amount = $value['quantity'];

                if($amount == 0){
                    continue;
                }

                $this->saveStock($product_id, $amount, null);
            }


            $rs->status = true;

        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function amountUpdate()
    {
        $rs = new ResultClass();
        try {

            $id = request()->get('id');
            $amount = request()->get('amount');

            $mdl = DaysStocks::find($id);
            $mdl->update_user_id = Auth::user()->id;
            $mdl->updated_at = Carbon::now();
            $mdl->amount = $amount;

            if ($mdl->save()) {
                $rs->status = true;
            }else{
                $rs->status = false;
            }

        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
