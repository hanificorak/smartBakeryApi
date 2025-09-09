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

            $rs->obj = User::where('firm_id', Auth::user()->firm_id)->get();
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
            $id = request()->get('id');
            $perm = request()->get('perm');
            $status = request()->get('status');

            $firm_id = Auth::user()->firm_id;

            if ($id == null) {
                $mdl = new User();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->password =  Hash::make($password);
            } else {
                $mdl = User::find($id);
                $mdl->updated_at = Carbon::now();

                if($password != null && $password != ""){
                    $mdl->password =  Hash::make($password);
                }
            }

            $mdl->email = $email;
            $mdl->name = $name;
            $mdl->firm_id = $firm_id;
            $mdl->is_admin = $perm;
            $mdl->status = $status;


            $mdl->save();


            return ["status" => true];
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
    }

    public function getWaitData()
    {
        $rs = new ResultClass();
        try {

            $rs->obj = User::where('firm_id', Auth::user()->firm_id)->where('admin_onay', 0)->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
        return $rs;
    }
    public function approve()
    {
        $rs = new ResultClass();
        try {

            $user_id = request()->get('id');

            $mdl = User::find($user_id);
            $mdl->admin_onay = 1;

            $mdl->save();
            $rs->status = true;
        
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
        return $rs;
    }
}
