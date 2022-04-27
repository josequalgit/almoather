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
}
