<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;
use App\Models\EndOfDays;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SystemController
{

    public function addToken()
    {

        $token = request()->get('token');
        if ($token == null) {
            return;
        }

        $mdl = User::find(Auth::user()->id);
        $mdl->notification_token = $token;
        $mdl->save();
    }

    public function dataCheck()
    {
        try {

            $check = EndOfDays::where('firm_id', Auth::user()->firm_id)->whereDate('created_at', Carbon::now())->exists();
            if($check){
                return ['status' => true];
            }else{
                return ['status' => false];
            }
        
        } catch (\Throwable $th) {
            return ['status' => false];
        }
    }
}
