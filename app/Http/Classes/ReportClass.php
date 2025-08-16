<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
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

class ReportClass
{

    public function getReportData()
    {
        $rs = new ResultClass();
        try {

            $date = Carbon::now();
            $product = request()->get('product');
            $weather = request()->get('weather');
            $dateRange = request()->get('date');

            $query = EndOfDays::with(['product', 'weather']);

            if ($product != null) {
                $query->where('product_id', $product);
            }

            if ($weather != null) {
                $query->where('weather_code', $weather);
            }
            $startDate = null;
            $endDate = null;
            switch ($dateRange) {
                case 'today': // Bugün
                    $startDate = Carbon::today(); // Bugünün başlangıcı
                    $endDate = Carbon::today()->endOfDay(); // Bugünün sonu
                    break;

                case 'week': // Bu hafta
                    $startDate = Carbon::now()->startOfWeek(); // Haftanın başlangıcı (Pazartesi)
                    $endDate = Carbon::now()->endOfWeek(); // Haftanın sonu (Pazar)
                    break;

                case 'month': // Bu ay
                    $startDate = Carbon::now()->startOfMonth(); // Ayın başlangıcı
                    $endDate = Carbon::now()->endOfMonth(); // Ayın sonu
                    break;

                default:
                    $startDate = null;
                    $endDate = null;
                    break;
            }


            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $rs->obj = $query->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
