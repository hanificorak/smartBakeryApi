<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        return ["status" => true, 'access_token' => $token];
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
}
