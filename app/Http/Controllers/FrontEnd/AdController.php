<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Models\Relation;
use App\Models\CampaignGoal;
use App\Models\Country;
use App\Models\Ad;

class AdController extends Controller
{
    public function create()
    {
        $socialMedia = SocialMedia::get();
        $relations = Relation::get();
        $goals = CampaignGoal::get();
        
        $countries = Country::where('is_location',1)->get();

        
        return view('frontEnd.ads.create',compact('socialMedia','relations','goals','countries'));
    }

    public function edit($id)
    {
        $cookie =  \Cookie::get('jwt_token');
        $data = Ad::findOrFail($id);
        $socialMedia = SocialMedia::get();
        $relations = Relation::get();
        $goals = CampaignGoal::get();
        
        $countries = Country::where('is_location',1)->get();

        return view('frontEnd.ads.edit',compact('data','socialMedia','relations','goals','countries'))->withCookie($cookie);
    }

    public function details($id)
    {
        $data = Ad::findOrFail($id);
        $cookie =  \Cookie::get('jwt_token');

        return view('frontEnd.ads.details',compact('data'))->withCookie($cookie);
    }

    public function go_to_payment()
    {
        /**Todo */
    }
}
