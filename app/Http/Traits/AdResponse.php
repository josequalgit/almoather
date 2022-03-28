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
            'nearest_location'=>$ad->nearest_location,
            'has_discount_code'=>$ad->has_discount_code,
            'website_link'=>$ad->website_link,
            'delivery_man_name'=>$ad->delivery_man_name,
            'delivery_phone_number'=>$ad->delivery_phone_number,
            'delivery_city_name'=>$ad->delivery_city_name,
            'delivery_area_name'=>$ad->delivery_area_name,
            'delivery_street_name'=>$ad->delivery_street_name,
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