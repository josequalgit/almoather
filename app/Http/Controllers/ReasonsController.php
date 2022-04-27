<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;

class ReasonsController extends Controller
{
    public function index()
    {
        $setting = AppSetting::where('key','reasons')->first();
        if($setting)
        {
            $data = json_decode($setting->value);
        }
        else
        {
            $data = [];
        }
        return view('dashboard.reasons.index',compact('data'));
    }


    public function store(Request $request)
    {
        $setting = AppSetting::where('key','reasons')->first();
        if(!$setting)
        {
          $setting =  AppSetting::create([
                'key'=>'reasons',
                'value'=>json_encode([])
            ]);
        }
        $changeToArray = json_decode($setting->value);
        array_push($changeToArray,$request->text);
        $setting->value = json_encode($changeToArray);
        $setting->save();
        return response()->json([
            'msg'=>'reason was added',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }
}
