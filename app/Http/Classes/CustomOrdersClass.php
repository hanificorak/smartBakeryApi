<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\CustomOrderProducts;
use App\Models\CustomOrders;
use App\Models\DaysInfo;
use App\Models\DaysStocks;
use App\Models\EndOfDays;
use App\Models\Products;
use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReportMail;

class CustomOrdersClass
{

    public function getCustomOrders()
    {
        $rs = new ResultClass();
        try {



            $rs->obj = CustomOrders::with('orderProducts.product')
                ->where('firm_id', Auth::user()->firm_id)
                ->orderByDesc('id')
                ->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function add()
    {
        $rs = new ResultClass();
        try {

            $name_surname = request()->get('name_surname');
            $phone = request()->get('phone');
            $products = request()->get('products');
            $desc = request()->get('desc');
            $id = request()->get('id');
            $delivery_date = request()->get('delivery_date');

            DB::beginTransaction();

            if ($id == null) {
                $mdl = new CustomOrders();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->created_at = Carbon::now();
                $mdl->updated_at = null;
                $mdl->firm_id = Auth::user()->firm_id;
            } else {
                $mdl = CustomOrders::find($id);
                $mdl->update_user_id = Auth::user()->id;
                $mdl->updated_at = Carbon::now();
            }


            $mdl->name_surname = $name_surname;
            $mdl->phone = $phone;
            $mdl->product_id = -1;
            $mdl->amount = 1;
            $mdl->desc = $desc;
            $mdl->delivery_date = Carbon::parse($delivery_date)->format('Y-m-d');

            if ($mdl->save()) {

                foreach ($products as $key => $value) {
                    $pr = new CustomOrderProducts();
                    $pr->created_at = Carbon::now();
                    $pr->create_user_id = Auth::user()->id;
                    $pr->updated_at = null;
                    $pr->product_id = $value['product_id'];
                    $pr->amount = $value['amount'];
                    $pr->order_id = $mdl->id;
                    $pr->save();
                }

                DB::commit();
                $rs->status = true;
            } else {
                DB::rollBack();
                $rs->status = false;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
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
            $mdl = CustomOrders::find($id);

            if ($mdl->delete()) {
                DB::table('custom_order_products')->where('order_id', $id)->delete();
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


    public function printOrder()
    {
        $rs = new ResultClass();
        try {

            $id = request()->get('id');
            $lang = request()->get('lang');
            $mail = request()->get('mail');
            $print = request()->get('print');

            if ($lang == null) {
                $lang = 'de';
            }

            App::setLocale($lang);


            $data = CustomOrders::with('orderProducts.product')
                ->where('firm_id', Auth::user()->firm_id)
                ->orderByDesc('id');
            if ($id != null) {
                $data->where('custom_orders.id', $id);
            }

            $data  = $data->get();


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

            $rs->status = true;

            if ($print == 0) {
                Mail::to($mail)->send(new ReportMail($url));
            }
            $rs->obj = $url;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }
}
