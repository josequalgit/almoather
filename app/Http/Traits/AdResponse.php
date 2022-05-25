<?php

namespace App\Http\Traits;
use Auth;
use App\Models\Contract;
use App\Models\CampaignContract;
use App\Models\InfluencerContract;

trait AdResponse {


    public function adResponse($ad)
    {
        $info = $ad->influncers?$ad->influncers()->get()->map(function($item){
          return $this->userDataResponse([],null,$item->users->id);
        }):null;

		
      $basicResponse =  [
            'id'=>$ad->id,
            'image'=>$ad->image,
            'videos'=>$ad->videos,
            'cr_certificate'=>$ad->document,
            'campaign_goal'=>$ad->campaignGoals->title,
            'logo'=>$ad->logo,
            // 'locations'=>$ad->storeLocation?$ad->storeLocations()->get()->map(function($item){
            //   return $item->cities->name.','.$item->areas->name.','.$item->countries->name;
            // }):null,
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
            'customer_id'=>$ad->customers->id,
            'isVat'=>$ad->is_vat,
            'discount_code'=>$ad->discount_code,
            'hasStore'=>$ad->has_hasStore?true:false,
            'is_onSite'=>$ad->onSite?'Online':'Site',
            'tax_value'=>$ad->tax_value,
           
      ];

      if($ad->status !== 'approve'&&$ad->status !== 'prepay' && $ad->status !== 'pending' &&Auth::guard('api')->user()->customers)
      {
        $data =  Contract::select('content')->where([['customer_id',Auth::guard('api')->user()->customers->id],['ad_id',$ad->id]])->first();
        $basicResponse['contract'] = $data?$data->content:null;
      }

      if(Auth::guard('api')->user()->customers&&$ad->status !== 'pending'&&$ad->status !== 'approve'&&$ad->status !== 'prepay'&&$ad->status !== 'rejected')
      {
        $basicResponse['matches'] = $ad->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item){
          $contract = InfluencerContract::where('influencer_id',$item->influencer_id)->first();

          $status = null;
         
          if(isset($contract)&&$contract->is_accepted == 2)
          {
            $status = 'rejected';
          }
          else if(isset($contract)&&$contract->is_accepted == 1)
          {
            if($contract->status == 1&&$contract->admin_status == 1)
            {
              $status = 'completed';
            }
            else
            {
              $status = 'progress';
            }
          }
          else
          {
            if(isset($contract)&&$contract->date)
            {
              $status = 'was sent';
            }
            else
            {
              $status = 'not sent';
            }
          }
          return [
            'id'=>$item->influencers->id,
            'image'=>$item->influencers->users->infulncerImage,
            'name'=>$item->influencers->first_name.' '.$item->influencers->middle_name.' '.$item->influencers->last_name,
            'match'=>$item->match,
            'status'=>$status
          ];
        });
      }
      

      if(Auth::guard('api')->user()->customers){
      
        $basicResponse['status']=$ad->status;
      }

      
      return $basicResponse;
    }
}