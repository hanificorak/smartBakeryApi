<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserClass
{

    public function getUsers()
    {
        $rs = new ResultClass();
        try {

            $rs->obj = User::where('firm_id', Auth::user()->firm_id)->whereNot('is_admin',0)->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
        return $rs;
    }

    public function addUser()
    {
        try {

            $name = request()->get('name');
            $email = request()->get('email');
            $password = request()->get('password');


            $firm_id = Auth::user()->firm_id;


            $mdl = new User();
            $mdl->create_user_id = Auth::user()->id;
            $mdl->email = $email;
            $mdl->name = $name;
            $mdl->firm_id = $firm_id;
            $mdl->password =  Hash::make($password);


            $mdl->save();


            return ["status" => true];
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
    }


}
