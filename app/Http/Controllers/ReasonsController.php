<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use Alert;

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
        Alert::toast('Reason Was added', 'success');
        return response()->json([
            'msg'=>'reason was added',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        $setting = AppSetting::where('key','reasons')->first();
        $changeToArray = json_decode($setting->value);
        unset($changeToArray[$id]);
        dd($changeToArray);
        $setting->value = json_encode($changeToArray);
     //   dd($setting);

        $setting->save();
        Alert::toast('Reason Was deleted', 'success');
        return response()->json([
            'msg'=>'reason was deleted',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }
}
