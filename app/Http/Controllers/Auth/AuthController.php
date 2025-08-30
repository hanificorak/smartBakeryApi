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

        $user_check = User::where('email', request()->get('email'))->first();

        return ["status" => true, 'access_token' => $token, 'admin_status' => $user_check->is_admin];
    }

  public function register(Request $request)
{
    try {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $firm_id = $request->input('firm_id');

        // Eğer firm_id null ise, yeni bir firm_id oluştur
        if ($firm_id == null) {
            $firm_id = DB::table('users')->max('id') + 1;
        }

        // User modelinin yeni bir örneğini oluştur
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->firm_id = $firm_id; // firm_id'yi doğru şekilde atayın

        // Veriyi kaydet
        $user->save();

        return ["status" => true, "user_id" => $user->id];
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
