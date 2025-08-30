<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Mail\ReportMail;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
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

class FreezerClass
{

    public function getData()
    {
        $rs = new ResultClass();
        try {

            $date = request()->get('date');

            $query = Freezers::where('firm_id', Auth::user()->firm_id);
            if ($date != null) {
                $query->whereDate('created_at', Carbon::parse($date));
            }

            $rs->obj = $query->get();
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

            $name = request()->get('name');
            $temp = request()->get('temp');
            $desc = request()->get('desc');
            $id = request()->get('id');

            if ($id == null) {

                $mdl = new Freezers();
                $mdl->created_at = Carbon::now();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->updated_at = null;
                $mdl->firm_id = Auth::user()->firm_id;
            } else {

                $mdl =  Freezers::find($id);
                $mdl->updated_at = Carbon::now();
                $mdl->update_user_id = Auth::user()->id;
                $mdl->firm_id = Auth::user()->firm_id;
            }


            $mdl->name = $name;
            $mdl->temp = $temp;
            $mdl->desc = $desc;

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

    public function delete()
    {
        $rs = new ResultClass();
        try {

            $id = request()->get('id');

            if (DB::table('freezers')->where('id', $id)->delete()) {
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

    public function createReport()
    {
        $rs = new ResultClass();
        try {

            $mail = request()->get('email');
            $startDate = request()->get('start');
            $endDate = request()->get('end');

            $query = Freezers::query();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $query = $query->get();


            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }
            $randomFileName = 'freezer-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;
            $company = Settings::where('firm_id', Auth::user()->firm_id)->first();

            $pdf = Pdf::loadView('reports.freezer-report', compact('company','query'));
            $pdf->setPaper('A4', 'portrait');
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
