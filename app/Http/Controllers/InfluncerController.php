<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influncer;
use App\Models\Country;
use App\Models\SocialMediaProfile;
use App\Models\SocialMedia;
use App\Models\AppSetting;
use App\Models\Bank;
use App\Models\InfluncerCategory;
use Alert,Auth;
use App\Http\Requests\UpdateInfluencerRequest;
use Carbon\Carbon;

class InfluncerController extends Controller
{
    public function index($status = 'accepted')
    {
        $allStatus = ['pending','accepted','rejected','band'];
        

        $status = in_array($status,$allStatus) ? $status : 'active';
        
        $data = Influncer::where('status',$status);
        $counter = $data->count();
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $influencerData = [];

        foreach($months as $month)
        {
            $influencerNumber = Influncer::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('created_at', '=', $month)
            ->count();
            array_push($influencerData,$influencerNumber);
        }

       $data =  $data->orderBy('created_at','desc')->paginate(24);
       

        return view('dashboard.influncers.index',compact('data','counter','influencerData','status'));
    }

    public function edit($id)
    {
        $data = Influncer::findOrFail($id);
        $infCategories = $data->InfluncerCategories->pluck('id')->toArray();
        $categories = InfluncerCategory::get();
        $nationalities = Country::get();
        $countries = Country::where('is_location',1)->get();
        $banks = Bank::select(['id','name'])->get();
        $socialMedia = SocialMedia::get();
        $settings = AppSetting::where('key','tax')->first();
        $tax = $settings ? $settings->value : config('global.TAX');

        return view('dashboard.influncers.edit',compact('data','tax','socialMedia','categories','infCategories','nationalities','countries','banks'));
    }

    public function update(UpdateInfluencerRequest $request , $id)
    {

        $influencer = Influncer::find($id);
        if(!$influencer){
            return response()->json([
                'err'=>'Influncer not found',
                'status'=> false
            ],404);
        } 

        $oldStatus = $influencer->status;
        $request->rejected_note = $request->status == 'rejected' ? $request->rejected_note : '';

        $data = $request->except('image', '_token','categories');
        $influencer->update($data);
        if($request->hasFile('image')){
            $influencer->users->clearMediaCollection('influncers');
            $influencer->users->addMedia($request->file('image'))->toMediaCollection('influncers');
        }

        $influencer->InfluncerCategories()->sync($request->categories);

        foreach ($request->social_media as $item) {
            $obj = (object)$item;
            if(trim($obj->link)){
                if($obj->type == 4){
                    $influencer->update(['subscribers' => $obj->subscribers]);
                }
                SocialMediaProfile::updateOrCreate([
                    'Influncer_id'      => $influencer->id,
                    'social_media_id'   => $obj->type
                ],[
                    'link'              => $obj->link,
                    'views'              => $obj->subscribers ?? 0,
                    'Influncer_id'      => $influencer->id
                ]);
            }else{
                SocialMediaProfile::where(['Influncer_id' => $influencer->id,'social_media_id' => $obj->type])->delete();
            }   
        }

        if($oldStatus != $influencer->status){
            activity()->log('Admin "'.Auth::user()->name.'" changed "'. $influencer->full_name_en .'" influencer status');
        }
        
        Alert::toast('Influncer status was changed', 'success');

        return response()->json([
            'message'=>'data was updated',
            'status'=>true
        ]);
    }

    public function allInfluncerWithViews ()
    {
        $data = Influncer::paginate(10);

        return view('dashboard.influncers.allWithView',compact('data'));
    }
}
