<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SystemController
{

    public function addToken()  {
        
        $token = request()->get('token');
        if($token == null){
            return;
        }
        
        $mdl = User::find(Auth::user()->id);
        $mdl->notification_token = $token;
        $mdl->save(); 
    }
    

}
