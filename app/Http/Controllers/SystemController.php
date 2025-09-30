<?php

namespace App\Http\Controllers;

use App\Http\Classes\DefinitonsClass;
use App\Http\Classes\StockClass;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Freezers;
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

            $product_entry = DaysStocks::where('firm_id', Auth::user()->firm_id)
                ->whereDate('created_at', Carbon::today())
                ->where(function ($q) {
                    $q->whereNull('desc')
                        ->orWhere('desc', '<>', 'Ertesi günden aktarılan kayıt.');
                })
                ->exists();
            $end_of_days = EndOfDays::where('firm_id', Auth::user()->firm_id)->whereDate('created_at', Carbon::now())->exists();
            $freezer = Freezers::where('firm_id', Auth::user()->firm_id)->whereDate('created_at', Carbon::now())->exists();


            return [
                "product" => $product_entry,
                "end_of_days" => $end_of_days,
                "freezer" => $freezer
            ];
        } catch (\Throwable $th) {
            return ['status' => false];
        }
    }
}
