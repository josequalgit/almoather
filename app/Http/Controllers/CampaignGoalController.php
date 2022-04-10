<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SuperAdminRequest;
use App\Models\AppSetting;

class CampaignGoalController extends Controller
{
    public function index()
    {
        
        $data = AppSetting::where('key','Campaign Goal')->first()->campaignGoal;
        return view('dashboard.campaignGoals.index',compact('data'));
    }
}
