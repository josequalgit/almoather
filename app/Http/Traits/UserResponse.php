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
             'id'=>$user->id,
             'full_name' =>$info->full_name,
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
             'commercial_registration_no'=>$info->commercial_registration_no,
             'tax_registration_number'=>$info->tax_registration_number,
             'rep_full_name'=>$info->rep_full_name,
             'rep_id_number_name'=>$info->rep_id_number_name,
             'rep_phone_number'=>$info->rep_phone_number,
             'rep_email'=>$info->rep_email,
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
                'commercial_registration_no'=>$info->commercial_registration_no,
                'tax_registration_number'=>$info->tax_registration_number,
                'starting_date'=>$info->starting_date,
           ];
           if($token) $formate['token'] = $token; 

       }


       return $formate;
    }
}