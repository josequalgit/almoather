<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use Alert;

class GeneralController extends Controller
{
    public function index()
    {
        $setting = AppSetting::where('key','expired_info')->first();
        if($setting->value){
            $data = json_decode($setting->value);
        }else{
            $data = [
                'campaign_first_payment_period' => config('global.CAMPAIGN_FIRST_PAYMENT_PERIOD'),
                'campaign_first_payment_reminder' => config('global.CAMPAIGN_FIRST_PAYMENT_REMINDER'),
                'campaign_full_payment_period' => config('global.CAMPAIGN_FULL_PAYMENT_PERIOD'),
                'campaign_full_payment_reminder' => config('global.CAMPAIGN_FULL_PAYMENT_REMINDER'),
            ];
        }
        $data = (object) $data;

        $tax = AppSetting::where('key','tax')->first();

        return view('dashboard.general.index',compact('data','tax'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'expired_info' => 'required',
            "expired_info.*"  => "required|numeric|min:0|max:100",
            'tax' => 'required',
        ]);

        AppSetting::updateOrCreate(['key' => 'expired_info'],['value' => json_encode($request->expired_info)]);
        AppSetting::updateOrCreate(['key' => 'tax'],['value' => $request->tax]);
        
        Alert::toast('Setting was updated', 'success');

        return back();
    }
}
