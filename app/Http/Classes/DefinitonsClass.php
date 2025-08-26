<?php

namespace App\Http\Classes;

use App\Http\Classes\Tools\ResultClass;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DefinitonsClass
{
    public function getProducts()
    {
        $rs = new ResultClass();
        try {

            $rs->obj = Products::where('firm_id', Auth::user()->firm_id)->orderByDesc('id')->get();
            $rs->status = true;
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function addProduct()
    {
        $rs = new ResultClass();
        try {

            $productName = request()->get('name');
            $shortDesc = request()->get('shortDesc');
            $desc = request()->get('desc');
            $id = request()->get('id');

            if ($id == null) {
                $mdl = new Products();
                $mdl->created_at = Carbon::now();
                $mdl->create_user_id = Auth::user()->id;
                $mdl->updated_at = null;
            } else {
                $mdl = Products::find($id);
                $mdl->updated_at = Carbon::now();
                $mdl->update_user_id = Auth::user()->id;
            }



            $mdl->name = $productName;
            $mdl->short_desc = $shortDesc;
            $mdl->desc = $desc;
            $mdl->firm_id = Auth::user()->firm_id;

            if ($mdl->save()) {
                $rs->status = true;
                $rs->obj = $mdl;
            } else {
                $rs->status = false;
                $rs->message = "Kayıt başarısız.";
            }
        } catch (\Throwable $th) {
            $rs->status = false;
            $rs->message = $th->getMessage();
        }
        return $rs;
    }

    public function productDelete()
    {
        $rs = new ResultClass();
        try {

            $id = request()->get('id');

            if (DB::table('products')->where('id', $id)->delete()) {
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
}
