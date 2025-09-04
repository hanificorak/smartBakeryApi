<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\CustomOrders;
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

class CustomOrdersClass
{

    public function getCustomOrders()
    {
        $rs = new ResultClass();
        try {

            $date = request()->get('date');
            if ($date == null) {
                $date = Carbon::now()->format('Y-m-d');
            } else {
                $date = Carbon::parse($date)->format('Y-m-d');
            }


            $rs->obj = CustomOrders::with('product')->where('firm_id', Auth::user()->firm_id)->whereDate('created_at', '=', $date)->orderByDesc('id')->get();
            $rs->status = true;
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

            $name_surname = request()->get('name_surname');
            $phone = request()->get('phone');
            $product_id = request()->get('product_id');
            $amount = request()->get('amount');
            $id = request()->get('id');

            if ($id == null) {
                $mdl = new CustomOrders();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->created_at = Carbon::now();
                $mdl->updated_at = null;
                $mdl->firm_id = Auth::user()->firm_id;
            } else {
                $mdl = CustomOrders::find($id);
                $mdl->update_user_id = Auth::user()->id;
                $mdl->updated_at = Carbon::now();
            }


            $mdl->name_surname = $name_surname;
            $mdl->phone = $phone;
            $mdl->product_id = $product_id;
            $mdl->amount = $amount;

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
            $mdl = CustomOrders::find($id);
            
            if ($mdl->delete()) {
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
