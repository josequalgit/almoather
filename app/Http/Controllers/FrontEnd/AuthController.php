<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Http\Request\LoginRequest;
use Alert;
use Auth;
class AuthController extends Controller
{
    public function login()
    {
        $setting = AppSetting::where('key','login_text')->first();
        $data = json_decode($setting->value);

        return view('frontEnd.auth.login',compact('data'));
    }

    public function login_submit(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return 'here';
        }
        else
        {
            Alert::toast('Invalid email or password', 'error');
            return back();
        }

    }

    public function register_type()
    {
        $setting = AppSetting::where('key','register_type')->first();
        $data = json_decode($setting->value);

        return view('frontEnd.auth.register_type',compact('data'));
    }

    public function customer_register()
    {
        return view('frontEnd.auth.register_customer');
    }
}
