<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Reason;
use Alert;

class ReasonsController extends Controller
{
    public function index()
    {
        $data = Reason::paginate(10);
        return view('dashboard.reasons.index',compact('data'));
    }


    public function store(Request $request)
    {
        $data = array_merge($request->all(),['text'=>[
            'ar'=>$request->reason_ar,
            'en'=>$request->reason_en,
        ]]);
        Reason::create($data);
        
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
        $setting->value = json_encode($changeToArray);

        $setting->save();
        Alert::toast('Reason Was deleted', 'success');
        return response()->json([
            'msg'=>'reason was deleted',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }
}
