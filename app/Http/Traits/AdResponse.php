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
            'category'=>$ad->categories->name,
            'date'=>$ad->date,
            'videos'=>$ad->videos,
            'social_media'=>$ad->socialMedias->image,
           'influencer'=> $info ? $this->userDataResponse($info->users) : null,
            'script'=>$ad->ad_script,
            'type'=>$ad->type,
            'is_onSite'=>$ad->onSite?'Online':'Site'
      ];
    }
}