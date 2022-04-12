<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SuperAdminRequest;
use App\Http\Requests\CampaignGoalRequest;
use App\Models\AppSetting;
use App\Models\CampaignGoal;
use Alert, Auth;

class CampaignGoalController extends Controller
{
    public function index()
    {
        $data = CampaignGoal::paginate(10);

        return view('dashboard.campaignGoals.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.campaignGoals.create');
    }

    public function store(CampaignGoalRequest $request)
    {
        //$data = AppSetting::where('key','Campaign Goal')->first();
        $data = CampaignGoal::create([
            'title'=>[
                'ar'=>$request->campaing_goal_ar,
                'en'=>$request->campaing_goal_en
            ],
            'customer_can_review'=>$request->customer_can_review ?? 0
        ]);
        

       activity()->log('Admin "'.Auth::user()->name.'" created new campaign goal');
       Alert::toast('Campaign goal was created', 'success');
        return redirect()->route('dashboard.campaignGoals.index');
    }

    public function edit($id)
    {   
        $data = CampaignGoal::find($id);
        // return $data;
       // return $data;
        return view('dashboard.campaignGoals.edit',compact('data'));
    }

    public function update(CampaignGoalRequest $request , $id)
    {
        $data = CampaignGoal::find($id);
        $data->title = [
            'en'=>$request->title_en,
            'ar'=>$request->title_ar,
        ];
        $data->customer_can_review = $request->customer_can_review??0;
        $data->save();


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
