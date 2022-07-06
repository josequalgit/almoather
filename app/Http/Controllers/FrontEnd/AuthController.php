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
use App;
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
        $token = '';
         if ($token = Auth::guard('api')->attempt(['email'=>$request->username,'password'=>$request->password])) {
            $bearer = 'Bearer '.$token;
            Auth::attempt(['email'=>$request->username,'password'=>$request->password]);
            // $request->headers->set('Authorization',$bearer);
            setcookie('jwt_token',$bearer);
            if(count(Auth::guard('api')->user()->roles) > 0)
            {
                Auth::guard('api')->logout();
                Auth::logout();
                return response()->json([
                    'msg'=>'Invalid email or password',
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }
            $is_user_verified = Auth::guard('api')->user()->email_verified_at?true:false;

            return redirect()->route($is_user_verified?'customers.index':'active_code')->header('Authorization',$bearer);
            // return response()->json([
            //     'data'=>[
            //         'url'=>$is_user_verified?route('customers.index'):route('auth.active_code'),
            //         'token'=>$token,
            //         'is_user_verified'=>$is_user_verified,
            //         'status'=>config('global.OK_STATUS')
            //     ],
            //     'status'=>config('global.OK_STATUS')
            // ],config('global.OK_STATUS'));
        }
        else
        {
             Alert::toast('Invalid email or password', 'error');
             return back();
            // return response()->json([
            //     'msg'=>'Invalid email or password',
            //     'status'=>config('global.WRONG_VALIDATION_STATUS')
            // ],config('global.WRONG_VALIDATION_STATUS'));
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

    public function changeLanguage()
    {
        if(App::getLocale() == 'ar')
        {
            // session()->put('locale', 'en');
            setcookie('language','en');
        }
        else
        {
            // session()->put('locale', 'ar');
            setcookie('language','ar');
        }
        return back();
    }

}
