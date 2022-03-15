<?php

namespace App\Http\Traits;

trait UserResponse {


    public function userDataResponse($user , $token = null)
    {
        $info = $user->influncers ?? $user->customers;
        $formate = [];
        
       if($user->influncers)
       {

           $formate = [
             'id'=>$info->id,
             'full_name_en' =>$info->full_name_en,
             'full_name_ar'=>$info->full_name_ar,
             'image'=>$user->infulncerImage,
             'nick_name'=>$info->nick_name,
             'nationality_id'=>$info->nationality_id,
             'country_id'=>$info->country_id,
             'region_id'=>$info->region_id,
             'city_id'=>$info->city_id,
             'influencer_category'=>$info->InfluncerCategories->pluck('id')->toArray(),
             'bio'=>$info->bio,
             'address_id'=>$info->address_id,
             'ad_price'=>$info->ad_price,
             'ad_onsite_price'=>$info->ad_onsite_price,
             'bank_id'=>$info->banks->id,
             'bank_account_number'=>$info->bank_account_number,
             'email'=>$user->email,
             'phone'=>$info->phone,
             'id_number'=>$info->id_number,
             'status'=>$info->status,
             'is_vat'=>$info->is_vat,
             'birthday'=>$info->birthday,
             'ads_out_country'=>$info->ads_out_country,
             'ad_with_vat'=>$info->ad_with_vat,
             'snap_chat_views'=>$info->snap_chat_views,
             'snap_chat_video'=>$user->snapChatVideo,
             'ad_onsite_price_with_vat'=>$info->ad_onsite_price_with_vat,
             'preferred_socialMedias'=>$info->socialMedias->pluck('id')->toArray(),
             'is_verify'=>$info->users->email_verified_at ? true : false,
         ];


         if($token) $formate['token'] = $token;

       }
       else
       {
           $formate = [
                'id'=>$user->id,
                'image'=>$user->image,
                'first_name' =>$info->first_name,
                'last_name'=>$info->last_name,
                'id_number'=>$info->id_number,
                'nationality_id'=>$info->nationalities->id,
                'country_id'=>$info->countrys->id,
                'region_id'=>$info->regions->id,
                'city_id'=>$info->citys->id,
                'email'=>$user->email,
                'phone'=>$info->phone,
           ];
           if($token) $formate['token'] = $token;

       }


       return $formate;
    }
}