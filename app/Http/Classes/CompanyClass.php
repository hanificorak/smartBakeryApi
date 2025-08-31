<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\Products;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyClass
{

    public function getData()
    {
        $rs = new ResultClass();
        try {

            
            $rs->obj = Settings::where('firm_id',Auth::user()->firm_id)->first();
            $rs->status = true;
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

            $title = request()->get('title');
            $address = request()->get('address');
            $phone = request()->get('phone');


            $item = Settings::where('firm_id',Auth::user()->firm_id)->select('id')->first();
            if($item == null){
                $mdl = new Settings();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->created_at = Carbon::now();
                $mdl->updated_at = null;
                $mdl->firm_id = Auth::user()->firm_id;
            }else{
                $mdl = Settings::find($item->id);
                $mdl->update_user_id = Auth::user()->id;
                $mdl->updated_at = Carbon::now();
            }

            
            $mdl->company_title = $title;
            $mdl->company_address = $address;
            $mdl->company_phone = $phone;

            if($mdl->save()){
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
