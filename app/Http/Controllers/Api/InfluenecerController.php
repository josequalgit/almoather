<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InfluncerCategory;
use Carbon\Carbon;

class InfluenecerController extends Controller
{
    public function details($id)
    {
        $data = User::find($id);
        #IF THE USER NOT FOUND
        if(!$data) return response()->json([
            'err'=>'user was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        #IF THE USER IS NOT AN INFLUENCER
        if(!$data->influncers) return response()->json([
            'err'=>'user is not a influenecer',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

        #GET THE USE SOCIAL MEDIA
        $get_social_media = $data->influncers->socialMedias()->get()->map(function($item){
            return[
                'name'=>$item->name,
                'logo'=>$item->image
            ];
        });
        
        #FORMATE THE RETURNED RESPONSE 
        $formate = [
            'name_ar'=>$data->influncers->full_name_ar,
            'name_en'=>$data->influncers->full_name_en,
            'about'=>$data->influncers->bio,
            'location'=>$data->influncers->countries->name,
            'nationalities'=>$data->influncers->nationalities->name,
            'videos'=>$data->influncers->video,
            'location'=>$data->influncers->nationalities->name,
            'social_media'=>$get_social_media,
        ];

        #RESPONSE
        return response()->json([
            'msg'=>'Influencer was found',
            'data'=>$formate,
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function get_matched_influencers($category_id)
    {
        $category = InfluncerCategory::find($category_id);

        if(!$category) return response()->json([
            'err'=>'category not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $data = $category->influncers;
        $now = Carbon::now();
        $year =  $now->year;
        $month =  $now->format('F');
        $week =  $now->weekOfYear;

        #CALCULATE THE ADS RATING LAST MONTH
        foreach($data as $inf)
        {
           $date = new Carbon('first day of '.$month.''.$year.'');
          $start_date = Carbon::parse($date)
          ->toDateTimeString();

          $end_date = Carbon::parse($date->days(28))
          ->toDateTimeString();

           $getInfAdsLast28 = $inf->ads()->whereBetween('created_at',[$start_date , $end_date])->get();
           $data = $getInfAdsLast28;

        }




        return $data;
    }

   
    
}
