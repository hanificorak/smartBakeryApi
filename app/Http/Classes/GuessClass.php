<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysInfo;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Holidays;
use App\Models\Products;
use App\Models\User;
use App\Models\WeatherCodes;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GuessClass
{


    public function getData($weather = null, $product_id = null)
    {
        $rs = new ResultClass();
        try {


            if ($weather == null) {
                $weather = request()->get('weather_code'); // Bugünün hava durumu
            }
            if ($product_id == null) {
                $product_id = request()->get('product_id');
            }

            $date = Carbon::now();
            $lastYearDate = $date->copy()->subYear(); // geçen seneki tarih

            // Önce bayram kontrolü yap
            $holiday = Holidays::whereDate('date', $lastYearDate->toDateString())->first();

            if ($holiday) {
                // Bayram günüyse hava durumu / gün hesapları yok
                $data = DaysInfo::whereDate('created_at', $lastYearDate->toDateString())
                    ->where('product_id', $product_id)
                    ->where('firm_id', Auth::user()->firm_id)
                    ->get();

                $count = $data->count();

                if ($count == 0) {
                    $rs->status = false;
                    $rs->obj = [
                        'holiday' => $holiday->name ?? 'Bayram',
                        'message' => "Geçen sene bu gün bayramdı ama satış verisi bulunamadı."
                    ];
                    return $rs;
                }

                $totalSold = $data->sum('sales_amount');
                $totalProduced = $data->sum('amount');

                $avgSold = round($totalSold / $count);
                $avgProduced = round($totalProduced / $count);
                $avgDiff = $avgProduced - $avgSold;

                $suggestedProduction = round($avgSold * 1.05);

                $product_info = Products::where('id', $product_id)->select('name')->first();

                $rs->status = true;
                $rs->obj = [
                    'holiday' => $holiday->name ?? 'Bayram',
                    'average_sold' => $avgSold,
                    'average_produced' => $avgProduced,
                    'average_diff' => $avgDiff,
                    'suggested_production' => $suggestedProduction,
                    'product' => $product_info->name,
                    'message' => "Geçen sene bugün {$holiday->name} idi. Satış ortalaması {$avgSold}. Bugün yaklaşık {$suggestedProduction} adet üretmen önerilir."
                ];
                return $rs;
            }

            // Normal gün ise (senin mevcut kodun çalışsın)
            $dayName = $date->translatedFormat('l');
            $dayNumber = $date->dayOfWeekIso;

            $data = DaysInfo::whereRaw('DAYOFWEEK(created_at) = ?', [$date->dayOfWeek + 1])
                ->where('product_id', $product_id)
                ->where('firm_id', Auth::user()->firm_id)
                ->where('weather_code', $weather)
                ->get();

            $count = $data->count();

            if ($count == 0) {
                $rs->status = false;
                $rs->obj = [
                    'weather' => $weather,
                    'day' => $dayName,
                    'message' => "Bugün için geçmiş veri bulunamadı."
                ];
                return $rs;
            }

            $totalSold = $data->sum('sales_amount');
            $totalProduced = $data->sum('amount');

            $avgSold = round($totalSold / $count);
            $avgProduced = round($totalProduced / $count);
            $avgDiff = $avgProduced - $avgSold;

            $suggestedProduction = round($avgSold * 1.05);

            $weather_item = WeatherCodes::where('id', $weather)->select('description')->first();
            $product_info = Products::where('id', $product_id)->select('name')->first();

            $rs->status = true;
            $rs->obj = [
                'weather' => $weather_item->description,
                'day' => $dayName,
                'average_sold' => $avgSold,
                'average_produced' => $avgProduced,
                'average_diff' => $avgDiff,
                'suggested_production' => $suggestedProduction,
                'product' => $product_info->name,
                'message' => "Bugün {$dayName}. Hava: {$weather_item->description}. Geçmişte ortalama {$avgProduced} üretip {$avgSold} satmışsın. 
                          Bugün yaklaşık {$suggestedProduction} adet üretmen önerilir."
            ];
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        return $rs;
    }

    public function totalGuessPdfMail()
    {
        $rs = new ResultClass();
        try {

            $weather = request()->get('weather');
            $email = request()->get('email');
            $print = request()->get('print');
            $lang = request()->get('lang');

            if ($lang == null) {
                $lang = 'de';
            }

            App::setLocale($lang);


            $products = Products::where('firm_id', Auth::user()->firm_id)->get();
            $datas = [];
            foreach ($products as $key => $value) {
                $product_id = $value->id;
                $result = $this->getData($weather, $product_id);
                $msg = $result->obj['message'];
                $prod_name = $value->name;

                array_push($datas, ["msg" => $msg, "prod_name" => $prod_name]);
            }

            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }
            $randomFileName = 'uretim-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;
            $pdf = Pdf::loadView('reports.guess-report', compact('datas'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->save($fullPath);

            $url = url('reports/' . $randomFileName);

            if ($print == 1) {
                $rs->obj = $url;
                $rs->status = true;
                return $rs;
            }
            Mail::to([$email])->send(new ReportMail($url));


            $rs->status = true;
            $rs->message = "OK";
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        return $rs;
    }
}
