<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegister;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserChangePass;
use App\Models\User;

class AuthController extends Controller
{
    // Ham dang ky 

    public function register(UserRegister $request)
    {
        $validated = $request->validated();
        $validated["password"] = bcrypt($validated["password"]);
        $user = User::create($validated);
        return response()->json(["user" => $user, 'msg' => 'Dang ky thanh cong'], 200);
    }

    // Dang nhap

    public function login(UserLogin $request)
    {
        $validated = $request->validated();

        if (auth()->attempt($validated)) {
            $user = auth()->user();
            $token = $user->createToken("vjshop.vn")->accessToken;
            return response()->json(['user' => $user, 'token' => $token, 'msg' => "Dang nhap thanh cong"], 200);
        } else {
            return response()->json(['msg' => "Dang nhap that bai"], 211);
        }
    }

    // Get me

    public function getMe()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }

    // Change pass

    public function changePassword(UserChangePass $request)
    {

        $validated = $request->validated();
        $user = auth()->user();
        $isUpdate = User::where('id', $user->id)
           // ->where('password', bcrypt($validated["old_password"]))
            ->update(["password" => bcrypt($validated["password"])]);
        if ($isUpdate) {
            return response()->json(['msg' => "Doi mat khau thanh cong"], 200);
        } else {
            return response()->json(['msg' => "Doi mat khau that bai"], 211);
        }
    }
}
