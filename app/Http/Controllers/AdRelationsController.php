<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use Alert;

class AdRelationsController extends Controller
{
    public function index()
    {
        $data = [];
        $setting = AppSetting::where('key','ads_relation')->first();
        if($setting){
            $data = $setting->campaignGoal;
        }
        else
        {
            $data = [];
        };
        return view('dashboard.adsRelations.index',compact('data'));
    }

    public function update(Request $request ,$id = null)
    {
        // FIND THE RIGHT SETTING TO UPDATED
        $settings = AppSetting::where('key','ads_relation')->first();

        // IF IT DOSE'T EXIST RETURN AN ERROR MESSAGE
        if(!$settings)
        {
            $settings = AppSetting::create([
                'key'=>'ads_relation',
                'value'=>json_encode(array())
            ]);
        };

        // IF THE SETTING EXIST MAKE THE STRING VALUE TO ARRAY
        $relation_array = (array)json_decode($settings->value);

        // PUSH THE NEW VALUE TO THE ARRAY
        if($id)
        {
            $relation_array[$id] = $request->relation;

        }
        else
        {
            array_push($relation_array,$request->relation);
        }

        $data = array_merge($request->all(),['value'=>json_encode($relation_array)]);

        $settings->update($data);

        Alert::toast('New ad relation was added', 'success');

        return response()->json([
            'msg'=>trans('messages.api.data_was_updated'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function delete($index)
    {
         // FIND THE RIGHT SETTING TO UPDATED
         $settings = AppSetting::where('key','ads_relation')->first();

         // IF IT DOSE'T EXIST RETURN AN ERROR MESSAGE
         if(!$settings) return response()->json([
             'msg'=>'ads relation settings not found',
             'status'=>config('global.WRONG_VALIDATION_STATUS')
         ],config('global.WRONG_VALIDATION_STATUS'));

         // IF THE SETTING EXIST CHANGE THE STRING VALUE TO ARRAY
         $relation_array = (array)json_decode($settings->value);

         // REMOVE RELATION FROM THE ARRAY ACCORDING TO THE INDEX
         unset($relation_array[$index]);

         // SAVE THE UPDATED ARRAY IN THE DATABASE
         $settings->update(['value'=>json_encode($relation_array)]);

         return response()->json([
            'msg'=>trans('messages.api.data_was_updated'),
            'status'=>config('global.UPDATED_STATUS')
        ],config('global.UPDATED_STATUS'));

    }
}
