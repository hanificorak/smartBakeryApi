<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysInfo;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ReportClass
{

    public function getReportData()
    {
        $rs = new ResultClass();
        try {

            $product = request()->get('product');
            $weather = request()->get('weather');
            $dateRange = request()->get('date');
            $startDateFilter = request()->get('startDate');
            $endDateFilter = request()->get('endDate');
            $active_lang = request()->get('lang');
            if ($active_lang == null) {
                $active_lang = 'de';
            }

            $query = DaysInfo::with(['product', 'weather'])->where('firm_id', Auth::user()->firm_id);

            if ($product != null) {
                $query->where('product_id', $product);
            }

            if ($weather != null) {
                $query->where('weather_code', $weather);
            }

            $startDate = null;
            $endDate = null;
            switch ($dateRange) {
                case 'heute': // Bugün
                    $startDate = Carbon::today()->startOfDay(); // Bugün 00:00
                    $endDate   = Carbon::today()->endOfDay();   // Bugün 23:59:59
                    break;
                case 'today': // Dün
                    $startDate = Carbon::yesterday()->startOfDay(); // Dün 00:00
                    $endDate   = Carbon::yesterday()->endOfDay();   // Dün 23:59:59
                    break;

                case 'week': // Geçen hafta
                    $startDate = Carbon::now()->subWeek()->startOfWeek(); // Geçen haftanın pazartesi 00:00
                    $endDate   = Carbon::now()->subWeek()->endOfWeek();   // Geçen haftanın pazar 23:59:59
                    break;

                case 'month': // Geçen ay
                    $startDate = Carbon::now()->subMonth()->startOfMonth(); // Geçen ayın başı
                    $endDate   = Carbon::now()->subMonth()->endOfMonth();   // Geçen ayın sonu
                    break;

                case 'custom':
                    $startDate = Carbon::parse($startDateFilter);
                    $endDate = Carbon::parse($endDateFilter);
                    break;
                default:
                    $startDate = null;
                    $endDate = null;
                    break;
            }


            // if ($startDate && $endDate) {
            //     $query->whereBetween('created_at', [$startDate, $endDate]);
            // }

            if ($startDate != null) {
                $query->whereDate('created_at', '>=', Carbon::parse($startDate)->format('Y-m-d'));
            }

            if ($endDate != null) {
                $query->whereDate('created_at', '<=', Carbon::parse($endDate)->format('Y-m-d'));
            }

            $dt = $query->get();

            foreach ($dt as $key => $value) {

                $dt[$key]->parentdate = null;
                $end_of_data = EndOfDays::where('id', $value->end_of_id)->first();
                if ($end_of_data != null) {
                    $ds_data = DaysStocks::where('id', $end_of_data->day_stock_id)->first();
                    if ($ds_data != null && $ds_data->parent_id != null) {
                        $dt[$key]->parentdate = $ds_data->getRootCreatedAt();
                    }
                }

                if ($value->weather) {
                    $dt[$key]->weather->description = $value->weather->{$active_lang} ?? $value->weather->description;
                }
            }
            $rs->obj = $dt;
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function reportSend()
    {
        $rs = new ResultClass();

        try {

            $lang = request()->get('lang_code');
            if ($lang == null) {
                $lang = 'de';
            }

            App::setLocale($lang); // 'tr', 'en' veya 'de'

            $type = request()->get('type');

            if ($type == "toplam") {
                $rs =  $this->totalreport();
            } else {
                $rs = $this->dayreport();
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function reportViewChange()
    {
        $rs = new ResultClass();
        try {

            $id = request()->get('id');

            $item = DaysInfo::where('id', $id)->first();

            $mdl = DaysInfo::find($id);
            $mdl->report_view = ($item->report_view == 1 ? 0 : 1);
            $mdl->updated_at = Carbon::now();

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

    public function totalreport()
    {
        $rs = new ResultClass();
        try {
            $productId = request()->get('product'); // değişken adı düzeltildi
            $weather = request()->get('weather');
            $dateRange = request()->get('date');
            $mail = request()->get('mail');
            $hiddenProd = request()->get('hiddenProd');
            $type_dt = request()->get('type_dt');
            $startDateFilter = request()->get('startDate');
            $endDateFilter = request()->get('endDate');


            $query = Products::select(
                'products.id',
                'products.name',
                DB::raw('SUM(days_info.amount) as total_amount'),
                DB::raw('SUM(days_info.sales_amount) as total_sales_amount'),
                DB::raw('SUM(days_info.remove_amount) as total_remove_amount'),
                DB::raw('SUM(days_info.ert_count) as total_ert_amount')
            )
                ->join('days_info', 'days_info.product_id', '=', 'products.id')
                ->where('products.firm_id', Auth::user()->firm_id)
                ->groupBy('products.id', 'products.name');


            if ($productId != null) {
                $query->where('products.id', $productId);
            }

            if ($weather != null) {
                $query->where('days_info.weather_code', $weather);
            }

            if (count($hiddenProd) > 0) {
                $query->whereNotIn('products.id', $hiddenProd);
            }

            $startDate = null;
            $endDate = null;
            switch ($dateRange) {
                case 'heute': // Bugün
                    $startDate = Carbon::today()->startOfDay(); // Bugün 00:00
                    $endDate   = Carbon::today()->endOfDay();   // Bugün 23:59:59
                    break;
                case 'today': // Dün
                    $startDate = Carbon::yesterday()->startOfDay(); // Dün 00:00
                    $endDate   = Carbon::yesterday()->endOfDay();   // Dün 23:59:59
                    break;

                case 'week': // Geçen hafta
                    $startDate = Carbon::now()->subWeek()->startOfWeek(); // Geçen haftanın pazartesi 00:00
                    $endDate   = Carbon::now()->subWeek()->endOfWeek();   // Geçen haftanın pazar 23:59:59
                    break;

                case 'month': // Geçen ay
                    $startDate = Carbon::now()->subMonth()->startOfMonth(); // Geçen ayın başı
                    $endDate   = Carbon::now()->subMonth()->endOfMonth();   // Geçen ayın sonu
                    break;

                case 'custom':
                    $startDate = Carbon::parse($startDateFilter);
                    $endDate = Carbon::parse($endDateFilter);
                    break;
                default:
                    $startDate = null;
                    $endDate = null;
                    break;
            }

            if ($startDate && $endDate) {
                $query->whereBetween('days_info.created_at', [$startDate, $endDate]);
            } else {
                $startDate = Carbon::now()->format('d.m.Y');
                $endDate = Carbon::now()->format('d.m.Y');
            }

            $reportData = $query->get();

            // Reports klasörü oluştur (yoksa)
            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }

            $randomFileName = 'genel-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;

            $company = Settings::where('firm_id', Auth::user()->firm_id)->first();

            $pdf = Pdf::loadView('reports.general-report', compact('reportData', 'startDate', 'endDate', 'company'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->save($fullPath);

            $url = url('reports/' . $randomFileName);
            if ($type_dt == "mail") {
                Mail::to($mail)->send(new ReportMail($url, $startDate, $endDate));
                $rs->obj = $url;
            } else {
                $rs->sub_info = $url;
                $rs->obj = $url;
            }

            $rs->status = true;
            $rs->message = "OK";
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }


    public function dayreport()
    {

        $rs = new ResultClass();
        try {
            $product = request()->get('product');
            $weather = request()->get('weather');
            $dateRange = request()->get('date');
            $mail = request()->get('mail');
            $startDateFilter = request()->get('startDate');
            $endDateFilter = request()->get('endDate');
            $hiddenProd = request()->get('hiddenProd');
            $weatherView = request()->get('weatherView');
            $type_dt = request()->get('type_dt');

            $active_lang =  request()->get('lang_code');
            if ($active_lang == null) {
                $active_lang = 'de';
            }

            $queryBase = DaysInfo::with(['product', 'weather'])

                ->where('report_view', 1)
                ->where('firm_id', Auth::user()->firm_id);

            if (count($hiddenProd) > 0) {
                $queryBase->whereNotIn('product_id', $hiddenProd);
            }

            if ($product != null) {
                $queryBase->where('product_id', $product);
            }

            if ($weather != null) {
                $queryBase->where('weather_code', $weather);
            }


            $startDate = null;
            $endDate = null;
            switch ($dateRange) {
                case 'heute': // Bugün
                    $startDate = Carbon::today()->startOfDay(); // Bugün 00:00
                    $endDate   = Carbon::today()->endOfDay();   // Bugün 23:59:59
                    break;
                case 'today': // Dün
                    $startDate = Carbon::yesterday()->startOfDay(); // Dün 00:00
                    $endDate   = Carbon::yesterday()->endOfDay();   // Dün 23:59:59
                    break;

                case 'week': // Geçen hafta
                    $startDate = Carbon::now()->subWeek()->startOfWeek(); // Geçen haftanın pazartesi 00:00
                    $endDate   = Carbon::now()->subWeek()->endOfWeek();   // Geçen haftanın pazar 23:59:59
                    break;

                case 'month': // Geçen ay
                    $startDate = Carbon::now()->subMonth()->startOfMonth(); // Geçen ayın başı
                    $endDate   = Carbon::now()->subMonth()->endOfMonth();   // Geçen ayın sonu
                    break;

                case 'custom':
                    $startDate = Carbon::parse($startDateFilter);
                    $endDate = Carbon::parse($endDateFilter);
                    break;
                default:
                    $startDate = null;
                    $endDate = null;
                    break;
            }

            // Günlük verileri saklamak için array
            $dailyReports = [];

            // Tarih aralığını günlere böl
            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $dayData = (clone $queryBase)
                    ->whereDate('created_at', $date->toDateString())
                    ->get();


                if (count($dayData) == 0) {
                    continue;
                }

                $dayData[0]->weather->description = $dayData[0]->weather->{$active_lang} ?? $dayData[0]->weather->description;
                $dailyReports[] = [
                    'date' => $date->format('d.m.Y'),
                    'data' => $dayData
                ];
            }


            // Reports klasörü oluştur (yoksa)
            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }

            // Random dosya adı oluştur
            $randomFileName = 'genel-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;

            // PDF oluştur

            $company = Settings::where('firm_id', Auth::user()->firm_id)->first();

            $pdf = Pdf::loadView('reports.general-report-day', [
                'dailyReports' => $dailyReports,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'company' => $company,
                'weather_view' => $weatherView
            ]);

            $pdf->setPaper('A4', 'portrait');
            $pdf->save($fullPath);

            $url = url('reports/' . $randomFileName);

            if ($type_dt == "mail") {
                Mail::to($mail)->send(new ReportMail($url, $startDate, $endDate));
                $rs->obj = $url;
            } else {
                $rs->obj = $url;

                $rs->sub_info = $url;
            }

            $rs->status = true;
            $rs->message = "OK";
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
