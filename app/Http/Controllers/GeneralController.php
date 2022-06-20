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
      
        if(!$setting) {
            AppSetting::create([
                'key'=>'expired_info',
                'value'=>json_encode( serialize([
                    'canceled_days_period'=>'28',
                    'warning_days_period'=>'28',
                    ]))
                ]);
                $setting = AppSetting::where('key','expired_info')->first();
        }
        $ser = json_decode($setting->value);
        $data = unserialize($ser);

        return view('dashboard.general.index',compact('data'));
    }

    public function update(Request $request)
    {
        $setting = AppSetting::where('key','expired_info')->first();
        $ser = json_decode($setting->value);
        $data = unserialize($ser);
        $data['canceled_days_period'] = $request->canceled_days_period;
        $data['warning_days_period'] = $request->warning_days_period;
        $setting->update([
            'value'=>json_encode(serialize($data))
        ]);
        Alert::toast('Setting was updated', 'success');

        return back();
    }
}
