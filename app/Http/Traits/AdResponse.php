<?php

namespace App\Http\Traits;
use Auth;
trait AdResponse {


    public function adResponse($ad)
    {
        $info = $ad->influncers()->get()->map(function($item){
          return $this->userDataResponse([],null,$item->users->id);
        });

		
      $basicResponse =  [
            'id'=>$ad->id,
            'image'=>$ad->image,
            'videos'=>$ad->videos,
            // 'documnet'=>$ad->documnet,
            'campaign_goal'=>$ad->campaignGoals->title,
            'logo'=>$ad->logo,
            'locations'=>$ad->storeLocation?$ad->storeLocations()->get()->map(function($item){
              return $item->cities->name.','.$item->areas->name.','.$item->countries->name;
            }):null,
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
            'influencer'=> $info ? $info : null,
            'budget'=>$ad->budget,
            'date'=>$ad->date,
            'type'=>$ad->ad_type,
            // 'nearest_location'=>$ad->nearest_location,
            'website_link'=>$ad->website_link,
            'about_product'=>$ad->about_product,
            // 'country'=>[
            //   'id'=>$ad->countries->id,
            //   'name'=>$ad->countries->name
            //  ],
            // 'city'=>[
            //   'id'=>$ad->cities->id,
            //   'name'=>$ad->cities->name
            // ],
            // 'area'=>[
            //   'id'=>$ad->areas->id,
            //   'name'=>$ad->areas->name
            // ],
            'customer_id'=>$ad->customer_id,
            'isVat'=>$ad->is_vat,
            'discount_code'=>$ad->discount_code,
            'hasStore'=>$ad->has_hasStore?true:false,
            'is_onSite'=>$ad->onSite?'Online':'Site',
           
      ];

      

      if(Auth::guard('api')->user()->customers){
        $basicResponse['status']=$ad->status;
      }

      
      return $basicResponse;
    }
}