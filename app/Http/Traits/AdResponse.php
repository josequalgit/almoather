<?php

namespace App\Http\Traits;
use Auth;
trait AdResponse {


    public function adResponse($ad)
    {
        $info = $ad->influncers;

		
      $basicResponse =  [
            'id'=>$ad->id,
            'image'=>$ad->image,
            'videos'=>$ad->videos,
            'documnet'=>$ad->documnet,
            'campaign_goal'=>$ad->campaignGoals->title,
            'logo'=>$ad->logo,
            'store_name'=>$ad->store,
            'marouf_num'=>$ad->marouf_num,
            'store_link'=>$ad->store_link,
              'prefired'=>$ad->socialMedias()->get()->map(function($item){
              return $item->image;
            }),
              'media_accounts'=>$ad->socialMediasAccount()->get()->map(function($item){
              return $item->image;
            }),
            'cr_num'=>$ad->cr_num,
            'about'=>$ad->about,
            'category'=>$ad->categories?$ad->categories->name:null,
            'scenario'=>$ad->scenario,
            'videos'=>$ad->videos,
            'influencer'=> $info ? $this->userDataResponse($info->users,null,$info->users->id) : null,
            'budget'=>$ad->budget,
            'type'=>$ad->ad_type,
            'nearest_location'=>$ad->nearest_location,
            'website_link'=>$ad->website_link,
            'country'=>[
              'id'=>$ad->countries->id,
              'name'=>$ad->countries->name
             ],
            'city'=>[
              'id'=>$ad->cities->id,
              'name'=>$ad->cities->name
            ],
            'area'=>[
              'id'=>$ad->areas->id,
              'name'=>$ad->areas->name
            ],
            'customer_id'=>$ad->customer_id,
            'category_id'=>$ad->category_id,
		        'influncer_id'=>$ad->influncer_id,
            'discount_code'=>$ad->discount_code,
            'hasStore'=>$ad->has_hasStore?true:false,
            'is_onSite'=>$ad->onSite?'Online':'Site',
           
      ];

      if(Auth::guard('api')->user()->influncers){
        $basicResponse['contract']=[
          'status'=>$ad->checkIfAccepted($info),
          'data'=>$ad->getInfAdContract($info),
        ];
      }

      if(Auth::guard('api')->user()->customers){
        $basicResponse['status']=$ad->status;
      }

      
      return $basicResponse;
    }
}