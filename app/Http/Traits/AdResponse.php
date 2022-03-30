<?php

namespace App\Http\Traits;

trait AdResponse {


    public function adResponse($ad)
    {
        $info = $ad->influncers;

      return [
            'id'=>$ad->id,
            'image'=>$ad->image,
            'store_name'=>$ad->store,
            'auth_number'=>$ad->auth_number,
            'budget'=>$ad->budget,
            'about'=>$ad->about,
            'location'=>$ad->countries->name,
            'category'=>$ad->categories?$ad->categories->name:null,
            'date'=>$ad->date,
            'videos'=>$ad->videos,
            'social_media'=>$ad->socialMedias->image,
           'influencer'=> $info ? $this->userDataResponse($info->users) : null,
            'script'=>$ad->ad_script,
            'scenario'=>$ad->scenario,
            'scenario'=>$ad->scenario,
            'type'=>$ad->type,
            'website_link'=>$ad->website_link,
            'social_media_id'=>$ad->social_media_id,
            'country_id'=>$ad->country_id,
            'city_id'=>$ad->city_id,
            'area_id'=>$ad->area_id,
            'customer_id'=>$ad->customer_id,
            'category_id'=>$ad->category_id,
            'discount_code'=>$ad->has_discount_code,
            'status'=>$ad->status,
            'hasStore'=>$ad->has_hasStore,
            'is_onSite'=>$ad->onSite?'Online':'Site'
      ];
    }
}