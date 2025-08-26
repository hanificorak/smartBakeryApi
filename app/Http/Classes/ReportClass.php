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
use Illuminate\Support\Facades\Mail;

class ReportClass
{

    public function getReportData()
    {
        $rs = new ResultClass();
        try {

            $product = request()->get('product');
            $weather = request()->get('weather');
            $dateRange = request()->get('date');

            $query = EndOfDays::with(['product', 'weather'])->where('firm_id',Auth::user()->firm_id);

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

    public function reportSend()
    {
        $rs = new ResultClass();

        try {


            $product = request()->get('product');
            $weather = request()->get('weather');
            $dateRange = request()->get('date');
            $mail = request()->get('mail');

            $query = EndOfDays::with(['product', 'weather'])->where('firm_id',Auth::user()->firm_id);

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
            }else{
                $startDate = Carbon::now()->format('d.m.Y');
                $endDate = Carbon::now()->format('d.m.Y');
            }

            $reportData = $query->get();


            // Reports klasörü oluştur (yoksa)
            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }

            // Random dosya adı oluştur
            $randomFileName = 'genel-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;

            // PDF oluştur
            $pdf = Pdf::loadView('reports.general-report', compact('reportData','startDate','endDate'));

            // PDF ayarları
            $pdf->setPaper('A4', 'portrait');

            // PDF'yi belirtilen konuma kaydet
            $pdf->save($fullPath);


            $url = url('reports/' . $randomFileName);
            Mail::to([$mail])->send(new ReportMail($url, $startDate, $endDate));

            $rs->status = true;
            $rs->message = "OK";
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
