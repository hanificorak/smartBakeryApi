<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\FreezerDefs;
use App\Models\Freezers;
use App\Models\Products;
use App\Models\Settings;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FreezerDefClass
{

    public function getData()
    {
        $rs = new ResultClass();
        try {

            $rs->obj = FreezerDefs::where('firm_id', Auth::user()->firm_id)->get();
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

            $title = request()->get('name');
            $id = request()->get('id');

            if ($id == null) {

                $mdl = new FreezerDefs();
                $mdl->created_at = Carbon::now();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->updated_at = null;
                $mdl->firm_id = Auth::user()->firm_id;
            } else {
                $mdl = FreezerDefs::where('id', $id)->where('firm_id', Auth::user()->firm_id)->first();
                $mdl->update_user_id = Auth::user()->id;
                $mdl->updated_at = Carbon::now();
            }
            $mdl->name = $title;
            $mdl->save();

            $rs->status = true;
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

            if(FreezerDefs::where('id',$id)->delete()){
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
