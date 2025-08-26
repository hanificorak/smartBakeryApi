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
use Illuminate\Support\Facades\Mail;

class GuessClass
{


public function getData()
{
    $rs = new ResultClass();
    try {
        $weather = request()->get('weather_code'); // Bugünün hava durumu
        $product_id = request()->get('product_id');
        $date = Carbon::now();

        // Gün ismi (örn: Pazartesi)
        $dayName = $date->translatedFormat('l');

        // Bugünün gün numarası (Pazartesi = 1 ... Pazar = 7)
        $dayNumber = $date->dayOfWeekIso;

        // Bugün ile aynı gün ve hava koşullarındaki geçmiş veriler
        $data = EndOfDays::whereRaw('DAYOFWEEK(created_at) = ?', [$date->dayOfWeek + 1])->where('product_id',$product_id)->where('firm_id',Auth::user()->firm_id)
            ->where('weather_code', $weather)
            ->get();

            $count = $data->count();

        if ($count == 0) {
            $rs->status = false;
            $rs->obj = [
                'weather' => $weather,
                'day' => $dayName,
                'message' => "Bugün için geçmiş veri bulunamadı. Hava durumu: {$weather}, gün: {$dayName}."
            ];
            return $rs;
        }

        $totalSold = $data->sum('current');   // satılan
        $totalProduced = $data->sum('amount'); // üretilen

        // Ortalama satılan ve üretilen miktar
        $avgSold = round($totalSold / $count);
        $avgProduced = round($totalProduced / $count);

        // Ortalama fark (israf veya eksik üretim)
        $avgDiff = $avgProduced - $avgSold;

        // Önerilen üretim: satış ortalaması + güvenlik payı (%5)
        $suggestedProduction = round($avgSold * 1.05);

        $weather_item = WeatherCodes::where('id',$weather)->select('description')->first();
        $product_info = Products::where('id',$product_id)->select('name')->first();
        $rs->status = true;
        $rs->obj = [
            'weather' => $weather_item->description,
            'day' => $dayName,
            'average_sold' => $avgSold,
            'average_produced' => $avgProduced,
            'average_diff' => $avgDiff,
            'suggested_production' => $suggestedProduction, // tahmini üretim sayısı
            'product' => $product_info->name, // tahmini üretim sayısı
            // 'message' => "Bugün {$dayName}. Hava: {$weather}. Geçmişte ortalama {$avgProduced} üretip {$avgSold} satmışsın. 
            //               Bugün yaklaşık {$suggestedProduction} adet üretmen önerilir."
        ];
    } catch (\Throwable $th) {
        $rs->status = false;
        $rs->message = $th->getMessage();
    }

    return $rs;
}

}
