<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Http\Request\LoginRequest;
use Alert;
use Auth;
use App\Models\Country;
use App\Models\Category;
use App\Models\SocialMedia;
use App\Models\Bank;

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
            if(count(Auth::user()->roles) > 0)
            {
                Auth::logout();
                Alert::toast("Invalid email or password", 'error');
                return back();
            }
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
        $nationality = Country::get();
        $countries = Country::where('is_location',1)->get();
        return view('frontEnd.auth.register_customer',compact('nationality','countries'));
    }
    public function influencer_register()
    {
        $nationality = Country::get();
        $countries = Country::where('is_location',1)->get();
        $categories = Category::get();
        $socialMedia = SocialMedia::get();
        $tax = AppSetting::where('key', 'tax')->first();
        $tax_num = $tax ? $tax->value : config('global.TAX');
        $banks= Bank::get();

        return view('frontEnd.auth.influencer_register',compact('nationality','countries','categories','socialMedia','tax_num','banks'));
    }

    public function active_code()
    {
        $setting = AppSetting::where('key','login_text')->first();
        $data = json_decode($setting->value);

        return view('frontEnd.auth.active_code',compact('data'));
    }
}
