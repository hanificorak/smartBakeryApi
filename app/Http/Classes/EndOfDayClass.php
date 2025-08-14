<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\DaysStocks;
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

            $rs->obj = DaysStocks::with(['product:id,name'])->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
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

            foreach ($data as $key => $value) {
                $id = $value['id']; // day_stock_id
                $current = $value['current']; // bugün satılan miktar
                $product_id = $value['current']; // bugün satılan miktar


            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
