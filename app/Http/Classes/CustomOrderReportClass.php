<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\CustomOrders;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class CustomOrderReportClass
{

    public function getReportData()
    {
        $rs = new ResultClass();
        try {

            $customer_name = request()->get('name_surname');
            $start_date = request()->get('start_date');
            $end_date = request()->get('end_date');
            $prodcut_id = request()->get('product_id');
           

            $query = CustomOrders::with('product')->where('firm_id', Auth::user()->firm_id);

            if ($customer_name != null) {
                $query = $query->where('name_surname', 'like', '%' . $customer_name . '%');
            }

            if ($start_date != null) {
                $start_date = Carbon::parse($start_date)->format('Y-m-d');
                $query = $query->whereDate('created_at', '>=', $start_date);
            }

            if ($end_date != null) {
                $end_date = Carbon::parse($end_date)->format('Y-m-d');
                $query = $query->whereDate('created_at', '<=', $end_date);
            }

            if ($prodcut_id != null) {
                $query = $query->where('product_id', $prodcut_id);
            }

            $rs->obj = $query->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function createReportMail()
    {
        $rs = new ResultClass();
        try {

            $customer_name = request()->get('name_surname');
            $start_date = request()->get('start_date');
            $end_date = request()->get('end_date');
            $prodcut_id = request()->get('product_id');
            $mail = request()->get('mail');
            $print = request()->get('print');
            $lang = request()->get('lang');

            if ($lang == null) {
                $lang = 'de';
            }

            App::setLocale($lang);

            $query = CustomOrders::with('product')->where('firm_id', Auth::user()->firm_id);
            $data = $query->get();

            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }

            $randomFileName = 'custom-order-report-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;

            $company = Settings::where('firm_id', Auth::user()->firm_id)->first();

            $pdf = Pdf::loadView('reports.custom-order-report', compact('data', 'company'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->save($fullPath);

            $url = url('reports/' . $randomFileName);

            if ($print == 1) {
                $rs->obj = $url;
                $rs->status = true;
                return $rs;
            }
            Mail::to($mail)->send(new ReportMail($url));

            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
