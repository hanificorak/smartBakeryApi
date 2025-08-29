<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = Auth::guard('api')->attempt($credentials)) {
                return ["status" => false, "message" => 'Geçersiz kullanıcı adı veya şifre'];
            }
        } catch (\Throwable $th) {
            return ["status" => false, "message" => 'İşlem başarısız.' . $th->getMessage()];
        }

       $user_check = User::where('email',request()->get('email'))->first();
     
        return ["status" => true, 'access_token' => $token, 'admin_status' => $user_check->is_admin];
    }

    public function register(Request $request)
    {
        try {

            $name = request()->get('name');
            $email = request()->get('email');
            $password = request()->get('password');
            $firm_id = request()->get('firm_id');

            if ($firm_id == null) {
                $firm_id = DB::table('users')->max('id') + 1;
            }

            $user = User::create([
                'email' => $email,
                'name' => $name,
                'firm_id' => $firm_id,
                'password' => Hash::make($password),
            ]);


            return ["status" => true];
        } catch (\Throwable $th) {
            return ["status" => false, 'message' => $th->getMessage()];
        }
    }


    public function userChange()
    {
        $user_id = request()->get('user_id');
        $user = User::find($user_id);

        if (! $user) {
            return ["status" => false, "message" => "Kullanıcı bulunamadı"];
        }

        try {

            $token = JWTAuth::fromUser($user);

            return [
                "status" => true,
                "access_token" => $token,
                "user" => $user
            ];
        } catch (\Throwable $th) {
            return ["status" => false, "message" => "İşlem başarısız: " . $th->getMessage()];
        }
    }
}
