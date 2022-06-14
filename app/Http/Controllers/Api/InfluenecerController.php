<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InfluncerCategory;
use App\Models\Influncer;
use Carbon\Carbon;
use Auth;
use DB;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Filters\Frame\FrameFilters;

class InfluenecerController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function details($id)
    {
        $data = User::find($id);
        #IF THE USER NOT FOUND
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'user_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        #IF THE USER IS NOT AN INFLUENCER
        if(!$data->influncers) return response()->json([
            'err'=>trans($this->trans_dir.'user_not_an_influencer'),
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
            'gallery' => $data->influncers->gallery
        ];

        #RESPONSE
        return response()->json([
            'msg'=>trans($this->trans_dir.'influencer_was_found'),
            'data'=>$formate,
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function get_matched_influencers($category_id)
    {
        $category = InfluncerCategory::find($category_id);

        if(!$category) return response()->json([
            'err'=>trans($this->trans_dir.'category_not_found'),
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

    function uploadMedia(Request $request){
        $validate = $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,jpg,svg,mp4,ogx,oga,ogv,ogg,webm'
        ]);
        $influencer = Auth::guard('api')->user()->influncers;
        if(!$influencer){
            return response()->json([
                'msg'       =>trans($this->trans_dir.'you_dont_have_permission'),
                'status'    => false,
            ],400);
        }

        $item = $influencer->addMedia($request->file('file'))->toMediaCollection('gallery');

        if(explode('/',$item->mime_type)[0] == 'video'){
            try {
                FFMpeg::fromDisk('custom')->open($item->getPath())->getFrameFromSeconds(5)->export()->addFilter(function (FrameFilters $filters) {
                    $filters->custom('scale=320:180');
                })->toDisk('local')->save('public/'.$item->id.'/thumbnail.png');

            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        return response()->json([
            'msg'       => trans($this->trans_dir.'media_added_successfully'),
            'data'      => $influencer->gallery,
            'status'    => true,
        ],200);
    }

    function getMedias(Request $request){
        
        $influencer = Auth::guard('api')->user()->influncers;
        if(!$influencer){
            return response()->json([
                'msg'       =>trans($this->trans_dir.'you_dont_have_permission'),
                'status'    => false,
            ],400);
        }

        return response()->json([
            'msg'       => trans($this->trans_dir.'media_returned_successfully'),
            'data'      => $influencer->gallery,
            'status'    => true,
        ],200);



    }

    function deleteGalleryMedia($id){
        $media = DB::table('media')->where('id',$id)->where('model_type','App\Models\Influncer')->first();
        if(!$media)return response()->json([
            'err'=>trans($this->trans_dir.'file_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $model_type = $media->model_type;
        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);

        return response()->json([
            'msg'       => trans($this->trans_dir.'media_deleted_successfully'),
            'status'    => true,
        ],200);
    }

   
    
}
