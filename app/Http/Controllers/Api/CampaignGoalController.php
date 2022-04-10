<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use Illuminate\Support\Facades\App;

class CampaignGoalController extends Controller
{
   public function index()
   {
    $data = AppSetting::where('key','Campaign Goal')->first()->campaignGoal;
    $lang = App::currentLocale();
    if(!in_array($lang,config('global.LANGS')))return response()->json([
        'msg'=>'lang is not supported',
        'status'=>config('global.WRONG_VALIDATION_STATUS')
    ],config('global.WRONG_VALIDATION_STATUS'));

    $goals = [];
    foreach ($data as $value) {
        $arr = array('ar'=>$value->ar,'en'=>$value->en);
       array_push($goals,$arr[$lang]);
    }
    
    return response()->json([
        'msg'=>'all campaign goals',
        'data'=>$goals,
        'status'=>config('global.OK_STATUS')
    ],config('global.OK_STATUS'));
   }
}
