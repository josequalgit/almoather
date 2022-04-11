<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SuperAdminRequest;
use App\Models\AppSetting;
use Alert, Auth;

class CampaignGoalController extends Controller
{
    public function index()
    {
        $data = AppSetting::where('key','Campaign Goal')->first()->campaignGoal;

        return view('dashboard.campaignGoals.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.campaignGoals.create');
    }

    public function store(Request $request)
    {
        $data = AppSetting::where('key','Campaign Goal')->first();
        
        $oldGoals = json_decode($data->value);
        $newData =(object)[
            'en'=>$request->campaing_goal_en,
            'ar'=>$request->campaing_goal_ar
        ];
        
       $addedData = array_push($oldGoals,$newData);
       $data->update([
           'value'=>json_encode($oldGoals)
       ]);

       activity()->log('Admin "'.Auth::user()->name.'" created new campaign goal');
       Alert::toast('Campaign goal was created', 'success');
        return redirect()->route('dashboard.campaignGoals.index');
    }

    public function edit($id)
    {   
        
        $goal = AppSetting::where('key','Campaign Goal')->first();
        $data = json_decode($goal->value)[$id];

        return view('dashboard.campaignGoals.edit',compact('data','id'));
    }

    public function update(Request $request , $id)
    {
        $goal = AppSetting::where('key','Campaign Goal')->first();
        $data = (array)json_decode($goal->value);
        $data[$id]->ar = $request->campaing_goal_ar;
        $data[$id]->en = $request->campaing_goal_en;

      
         $goal->value = json_encode($data);
        $goal->save();

        activity()->log('Admin "'.Auth::user()->name.'" updated campaign goals');
        Alert::toast('Campaign goals was updated', 'success');
        return redirect()->route('dashboard.campaignGoals.index');

    }


    public function delete($id)
    {
        $goal = AppSetting::where('key','Campaign Goal')->first();
        $data = (array)json_decode($goal->value);
        unset($data[$id]);

        $goal->value = json_encode($data);
        $goal->save();

        activity()->log('Admin "'.Auth::user()->name.'" deleted campaign goals');
        Alert::toast('Campaign goals was updated', 'success');
        return response()->json([
            'msg'=>'campaign goal was deleted',
            'status'=>200
        ],200);
    }
}
