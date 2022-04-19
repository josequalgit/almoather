<?php

namespace App\Http\Traits;
use App\Models\User;
use App\Models\SocialMediaProfile;

trait UserResponse {


    public function userDataResponse($user , $token = null , $id = null)
    {
        $user = User::find($id);
        $info = $user->influncers ?? $user->customers;
        
        $formate = [];
        
       if($user->influncers)
       {

           $formate = [
             'id'=>$user->id,
             'first_name' =>$info->first_name,
             'middle_name' =>$info->middle_name,
             'last_name' =>$info->last_name,
             'image'=>$user->infulncerImage,
            //  'address'=>$info->address,
             'nick_name'=>$info->nick_name,
             'nationality_id'=>$info->nationality_id,
             'nationality'=>$info->nationalities->name,
             'country_id'=>$info->country_id,
             'country'=>$info->countries->name,
             'region_id'=>$info->region_id,
             'region'=>$info->regions?$info->regions->name:null,
             'city_id'=>$info->city_id,
             'city'=>$info->citys?$info->citys->name:null,
             'influencer_category'=>$info->InfluncerCategories->pluck('id')->toArray(),
             'bio'=>$info->bio,
             'milestone'=>$info->milestone,
             'street'=>$info->street,
             'neighborhood'=>$info->neighborhood,
             'ad_price'=>$info->ad_price,
             'ad_onsite_price'=>$info->ad_onsite_price,
             'bank'=>$info->banks?[
                 'id'=>$info->banks->id,
                 'name'=>$info->banks->name,
             ]:null,
             'bank_account_number'=>$info->bank_account_number,
             'email'=>$user->email,
             'phone'=>$user->phone,
             'id_number'=>$info->id_number,
             'status'=>$info->status,
             'is_vat'=>$info->is_vat,
            //  'birthday'=>$info->birthday,
             'ads_out_country'=>$info->ads_out_country,
             'ad_with_vat'=>$info->ad_with_vat,
             'snap_chat_views'=>$info->snap_chat_views,
             'snap_chat_video'=>$user->snapChatVideo,
             'commercial_registration_no'=>$info->commercial_registration_no,
             'commercial_registration_no_files'=>$info->commercialFiles,
             'tax_registration_number'=>$info->tax_registration_number,
             'tax_registration_number_files'=>$info->taxFiles,
             'rep_first_name'=>$info->rep_first_name,
             'rep_middle_name'=>$info->rep_middle_name,
             'rep_last_name'=>$info->rep_last_name,
             'rep_id_number_name'=>$info->rep_id_number_name,
             'rep_phone_number'=>$info->rep_phone_number,
             'rep_email'=>$info->rep_email,
             'bank_account_first_name'=>$info->bank_account_first_name,
             'bank_account_middle_name'=>$info->bank_account_middle_name,
             'bank_account_last_name'=>$info->bank_account_last_name,
             'gender'=>$info->gender,
             'social_media_profile'=>$info->socialMediaProfiles()->get()->map(function($item){
                 return[
                     'id'=>$item->social_media_id,
                     'link'=>$item->link
                 ];
             }),
             'ad_onsite_price_with_vat'=>$info->ad_onsite_price_with_vat,
            //  'preferred_socialMedias'=>$info->socialMedias->pluck('id')->toArray(),
            //  'preferred_socialMedias_details'=>$info->socialMedias()->get()->map(function($item){
            //      return [
            //          'id'=>$item->id,
            //          'image'=>$item->image
            //      ];
            //  }),
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
                'middle_name' =>$info->middle_name,
                'last_name' =>$info->last_name,
                'id_number'=>$info->id_number,
                'nationality_id'=>$info->nationalities->id,
                'country_id'=>$info->countrys->id,
                'region_id'=>$info->regions->id,
                'city_id'=>$info->citys->id,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'gender'=>$info->gender,
                'id_number'=>$info->id_number,
                'is_verify'=>$info->users->email_verified_at ? true : false
           ];
           if($token) $formate['token'] = $token; 

       }


       return $formate;
    }
}