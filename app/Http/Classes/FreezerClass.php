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
use Illuminate\Support\Facades\App;
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

            $query = Freezers::where('freezers.firm_id', Auth::user()->firm_id)->join('freezer_defs', 'freezers.fr_id', '=', 'freezer_defs.id')->select('freezers.*', 'freezer_defs.name as fr_name', 'freezer_defs.id as fr_id')->orderBy('freezers.created_at', 'desc');
            if ($date != null) {
                $query->whereDate('freezers.created_at', Carbon::parse($date));
            }


            $data = [
                "data" => $query->get(),
                "freezers" => FreezerDefs::where('firm_id', Auth::user()->firm_id)->get()
            ];

            $rs->obj = $data;
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

            $fr_id = request()->get('fr_id');
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


            $mdl->fr_id = $fr_id;
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
            $startDate = request()->get('startDate');
            $endDate = request()->get('endDate');
            $print = request()->get('print');
            $print = request()->get('print');
            $prew = request()->get('prew');
            $mail_send = request()->get('mail');
            $lang = request()->get('lang');

            if ($lang == null) {
                $lang = 'de';
            }
            App::setLocale($lang);


            $query = Freezers::query()->where('freezers.firm_id', Auth::user()->firm_id)->join('freezer_defs', 'freezers.fr_id', '=', 'freezer_defs.id')->select('freezers.*', 'freezer_defs.name as fr_name', 'freezer_defs.id as fr_id')->orderBy('freezers.created_at', 'desc');

            // if ($startDate && $endDate) {
            //     $query->whereBetween('created_at', [Carbon::parse($startDate)->format('Y-m-d'), Carbon::parse($endDate)->format('Y-m-d')]);
            // }

            if ($startDate != null) {
                $startDate = Carbon::parse($startDate)->format('Y-m-d');
                $query = $query->whereDate('freezers.created_at', '>=', $startDate);
            }

            if ($endDate != null) {
                $endDate = Carbon::parse($endDate)->format('Y-m-d');
                $query = $query->whereDate('freezers.created_at', '<=', $endDate);
            }
            $query = $query->get();


            $reportPath = public_path('reports');
            if (!file_exists($reportPath)) {
                mkdir($reportPath, 0755, true);
            }
            $randomFileName = 'freezer-rapor-' . uniqid() . '-' . date('Ymd-His') . '.pdf';
            $fullPath = $reportPath . '/' . $randomFileName;
            $company = Settings::where('firm_id', Auth::user()->firm_id)->first();

            $pdf = Pdf::loadView('reports.freezer-report', compact('company', 'query'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->save($fullPath);

            $url = url('reports/' . $randomFileName);

            $rs->obj = $url;

            if ($mail_send == 1) {
                Mail::to([$mail])->send(new ReportMail($url));
                $rs->status = true;
                $rs->message = "OK";
                return $rs;
            }

            if ($print == 1) {
                $rs->status = true;
                return $rs;
            }

            if ($prew == 1) {
                $rs->status = true;
                return $rs;
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }

        return $rs;
    }
}
