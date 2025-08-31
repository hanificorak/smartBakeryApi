<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileClass
{
    public function updateProfile()
    {
        $rs = new ResultClass();
        try {

            $name = request()->get('name');
            $email = request()->get('email');

            $mdl = User::find(Auth::user()->id);
            $mdl->updated_at = Carbon::now();
            $mdl->name = $name;
            $mdl->email = $email;

            if ($mdl->save()) {
                $rs->status = true;
            } else {
                $rs->message = false;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function updatePassword()
    {
        $rs = new ResultClass();
        try {

            $last_pass = request()->get('last_pass');
            $new_pass = request()->get('new_pass');

            if (!Hash::check($last_pass, Auth::user()->password)) {
                $rs->status = false;
                $rs->sub_info = "last_error";
                return $rs;
            }

            $mdl =  User::find(Auth::user()->id);
            $mdl->password = Hash::make($new_pass);

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

    public function getProfileData()
    {
        $rs = new ResultClass();
        try {

            $rs->status = true;
            $rs->obj = Auth::user();
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
