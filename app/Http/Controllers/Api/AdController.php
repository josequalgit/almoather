<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Requests\Api\AdRequest;
use App\Http\Requests\Api\AcceptAdContractRequest;
use App\Http\Requests\Api\CheckPaymentRequest;
use App\Http\Requests\Api\UploadAdMedia;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\Influncer;
use App\Models\Relation;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\CampaignContract;
use App\Models\InfluencerContract;
use App\Models\StoreLocation;
use App\Models\AdsInfluencerMatch;
use App\Http\Traits\UserResponse;
use App\Http\Traits\ApiPaginator;
use App\Http\Traits\AdResponse;
use App\Http\Traits\SendNotification;
use Auth;
use Validator;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Log;
use DB;

class AdController extends Controller
{
    protected $guard = 'api';

    use ApiPaginator , UserResponse , AdResponse , SendNotification;

    private $trans_dir = 'messages.api.';
    private $trans_dir_notification = 'notifications.api.';

    //Return the list of ads based on Type (Customer / Influencer)
    public function index($status)
    {
        $user_id = Auth::guard('api')->user()->influncers ? Auth::guard('api')->user()->influncers->id :Auth::guard('api')->user()->customers->id;
      
        if(Auth::guard('api')->user()->influncers)
        {
            if(!in_array($status,config('global.INFLUENCER_ADS_STATUS'))){
                return response()->json([
                    'err'=>trans($this->trans_dir.'inf_wrong_status'),
                    'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
                ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
            }

            $statusCode = [
                'Pending'   => 0,
                'Rejected'  => 2,
                'Completed' => 1,
                'Active'    => 1
            ];

            $data = Auth::guard('api')->user()->influncers->contracts()->whereHas('ads');

            if($status == 'Completed'){
                $itemsPaginated =  $data->where('status',1)->where('is_accepted',$statusCode[$status]);
            }
            elseif($status == 'Active' || $status == 'Pending' || $status == 'Rejected')
            {
                $itemsPaginated =  $data->where('status',0)->where('is_accepted',$statusCode[$status]);
            }
          
            $itemsPaginated = $itemsPaginated->orderBy('created_at','desc')->paginate(10);
            $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($status){
                $data =  $this->adResponse($item->ads);
                $data['status']         = $status;
                $data['contract_id']    = $item->id;
                $data['contract_title'] = $item->title;
                $data['contract_data']  = $item->content;
                $data['contract_date']  = $item->date;    
                return $data;
            })->toArray();

            return response()->json([
                'msg'=>trans($this->trans_dir.'get_all_ads'),
                'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));


        }
        else
        {
            if(!in_array($status,config('global.CUSTOMER_ADS_STATUS'))) return response()->json([
                'err'=>trans($this->trans_dir.'customer_wrong_status'),
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

            $statusCode = [
                'Pending'           => ['approve','pending','prepay','choosing_influencer'],
                'Active'            => ['fullpayment','active','progress'],
                'Finished'          => ['complete']
            ];

            if(in_array($status,array_keys($statusCode)))
            {
                $itemsPaginated = Ad::where('customer_id',$user_id)->orderBy('created_at','desc')->whereIn('status',$statusCode[$status])->paginate(10);
            }
            else
            {
                $itemsPaginated = Ad::where([['customer_id',$user_id],['status',$status]])->orderBy('created_at','desc')->paginate(10);
            }

            $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                return $this->adResponse($item);
            })->toArray();
        }

        return response()->json([
            'msg'=>trans($this->trans_dir.'get_ads_with_status'),
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    //Create Campaign
    public function store(AdRequest $request)
    {
        #CHECK REQUEST 
        if(!$request->hasFile('commercial_doc') && !$request->has_marouf_num)
        {
            return response()->json([
                'err'=>trans($this->trans_dir.'upload_doc_or_add_auth_num'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        if($this->checkIfDataAvailable($request))
        {
            return response()->json([
                'err'=>$this->checkIfDataAvailable($request),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        

        $data = array_merge($request->all(),['customer_id'=>Auth::guard('api')->user()->customers->id,'price_to_pay' => $request->budget]);


        if($request->ad_type == 'onsite')
        {
            if($this->onSiteValidation($request))
            {
                return response()->json([
                    'err'=>$this->onSiteValidation($request),
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }
        }

        $data = Ad::create($data);

        $data->socialMediasAccount()->attach($request->prefered_media_id);
		$data->save();

		 if(count($request->social_media) > 0)
        {
            foreach ($request->social_media as $value) {

                DB::table('social_media_id')->insert([
                   'ad_id'=>$data->id,
                   'social_media_id'=>$value['type']??$value->type,
                   'link'=>$value['link']??$value->type
                ]);
			
            }
        }

        if($request->hasFile('cr_image'))
        {
            $data->addMedia($request->file('cr_image'))
            ->toMediaCollection('document');
        }
        if(!$request->has_marouf_num&&count($request->commercial_doc) > 0)
        {
            foreach ($request->commercial_doc as $key => $value) {
                $data->addMedia($value)
                ->toMediaCollection('commercial_docs');
            }
        }
        if($request->hasFile('logo'))
        {
            $data->addMedia($request->file('logo'))
            ->toMediaCollection('logos');
        }

        $users = [User::find(1)];
        $getAdmin = User::whereHas('roles',function($q){
            $q->where('name','superAdmin');
        })->get();

        $info =[
            'msg'=>trans($this->trans_dir.'customer').'"'.Auth::guard('api')->user()->customers->first_name.''.trans($this->trans_dir.'added_new_ad'),
            'id'=>$data->id,
            'type'=>'Ad'
        ];

       $this->sendAdminNotification('contract_manager_notification',$info);

        $c_not = Notification::send($getAdmin, new AddInfluencer($info));

        return response()->json([
            'msg'=>trans($this->trans_dir.'ad_was_created'),
            'data'=>$this->adResponse($data),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    //Create campaign validation
    private function checkIfDataAvailable($request)
    {
        if($request->country_id || $request->nationality_id)
        {
            $data = Country::find($request->country_id??$request->nationality_id);
            if(!$data) return trans($this->trans_dir.'country_not_found');
        }
        if($request->influncer_category_id)
        {
            $data = InfluncerCategory::find($request->influncer_category_id);
            if(!$data) return trans($this->trans_dir.'category_not_found');
        }
        if($request->city_id)
        {
            $data = City::find($request->city_id);
            if(!$data) return trans($this->trans_dir.'city_not_found');
        }
        if((isset($request->categories)&&count($request->categories) < 3) || (isset($request->categories)&&count($request->categories) > 3))
        {
            return trans($this->trans_dir.'should_categories_influencer');
        }
        if(isset($request->isVat)&&!$request->tax_registration_number)
        {
            return trans($this->trans_dir.'tax_registration_number_required');
        }

        return null;
    }

    //Add Details 
    public function details($id)
    {
        $data = Ad::find($id);

        if(!$data) return response()->json([
            'err'    => trans($this->trans_dir.'ad_not_found'),
            'status' => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'       => trans($this->trans_dir.'ad_details'),
            'data'      => $this->adResponse($data),
            'status'    => config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    // Return Add contract
    public function get_ad_contract($ad_id)
    {
        $ad = Ad::find($ad_id);
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(!$ad->contacts) return response()->json([
            'err'       => trans($this->trans_dir.'contract_not_found'),
            'status'    => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $matches = $ad->matches()->where('chosen', 1)->where('status','!=','deleted')->get();
        $hasInfluencerError = false;
        foreach($matches as $match){
            if(!$match->contract || !$match->contract->date || !$match->contract->scenario){
                $hasInfluencerError = true;
                break;
            }
        }

        if($hasInfluencerError){
            return response()->json([
                'message'=> 'Please Wait until we approve influencers list',
                'status'=> false
            ],config('global.OK_STATUS'));
        }

        return response()->json([
            'msg'   => trans($this->trans_dir.'ad_contract'),
            'data'  => route('contractApi',$ad->id),
            'status'=> config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    //Get campaign Contract
    public function getCampaignContract($campaign_id){
        $ad = Ad::find($campaign_id);
        $contract = CampaignContract::where('ad_id',$campaign_id)->first();

        $content = $contract->content;

        $startDate = $ad->InfluencerContract()->orderBy('date','asc')->first();
        $endDate = $ad->InfluencerContract()->orderBy('date','desc')->first();

        $content = str_replace("[[_CONTRACT_NUM_]]", $ad->id, $content);
        $content = str_replace("[[_CURRENT_DATE_]]", Carbon::now()->format('d/m/Y'), $content);
        $content = str_replace("[[_CUSTOMER_NAME_]]", $ad->customers->full_name, $content);
        $content = str_replace("[[_STORE_NAME_]]", $ad->store, $content);
        $content = str_replace("[[_CUSTOMER_NATIONALITY_]]", $ad->customers->nationalities->getTranslation('name','ar'), $content);
        $content = str_replace("[[_CR_NUM_]]", $ad->cr_num, $content);
        $content = str_replace("[[_NATIONAL_NUM_]]", $ad->customers->id_number, $content);
        $content = str_replace("[[_PHONE_]]", $ad->customers->users->phone, $content);
        $content = str_replace("[[_EMAIL_]]", $ad->customers->users->email, $content);
        $content = str_replace("[[_PRICE_WITH_TAX_]]", number_format($ad->adBudgetWithVat), $content);
        $content = str_replace("[[_PRICE_]]", number_format($ad->budget), $content);
        $content = str_replace("[[_START_DATE_]]", $startDate->date->format('d/m/Y'), $content);
        $content = str_replace("[[_END_DATE_]]", $endDate->date->format('d/m/Y'), $content);
        $content = str_replace("[[_CAMPAIGN_GOAL_]]", $ad->campaignGoals->getTranslation('title','ar'), $content);
        

        $title = $contract->ads->store;

        return $this->generateContractPdf($content,$title);

    }

    // Accept the contract For Influencer
    public function accept_ad_contract(AcceptAdContractRequest $request,$contract_id)
    {
        $data = InfluencerContract::find($contract_id);

        if(!$data) return response()->json([
            'err'    => trans($this->trans_dir.'contract_not_found'),
            'status' => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->is_accepted = $request->status == 0 ? 2 : $request->status;
        $data->rejectNote = $request->reject_note;
        $data->save();

        if($request->status == 0 && $request->rejectNote){
            $influencer = Influncer::find($data->influencer_id);
            $name = $influencer->nick_name;
            
            $info =[
                'msg'=>trans($this->trans_dir.'influencer').'"'.$name.'"'. trans($this->trans_dir.'reject_contract') .'"'.$data->rejectNote.'"'.' '.trans($this->trans_dir.'ad_small'),
                'id'=>$influencer->users->id,
                'type'=>'Influencer'
            ];

            $this->sendAdminNotification('contract_manager_notification',$info);
            $this->sendNotifications($data->ads->customers->users->fcm_token,$info);
            $getContactManagers = User::whereHas('roles',function($q){
                $q->where('name','Contracts Manager')
                ->orWhere('name','superAdmin');
            })->get();

            Notification::send($getContactManagers, new AddInfluencer($info));

        }

        if($request->status == 1)
        {
            $info =[
                'msg'=>trans($this->trans_dir.'influencer').'"'.$name.'"'. trans($this->trans_dir.'accept_contract'),
                'id'=>$influencer->users->id,
                'type'=>'Influencer'
            ];
            $this->sendNotifications($data->ads->customers->users->fcm_token,$info);
        }

        //ToDo Send notification for admin and customer campaign order

        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    // Search on Campaigns
    public function search($query)
    {
        $user = Auth::guard('api')->user();

        if($user->influncers){
            $data = $user->influncers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
        }else{
            $data = $user->customers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
        }

        $data->getCollection()->transform(function($item){
            return $this->adResponse($item);
        });

        return response()->json([
            'msg'       => trans($this->trans_dir.'search_result'),
            'data'      => $data,
            'status'    => config('global.OK_STATUS')
        ]);
    }

    // Get matched influencers
    //Todo Explain this
    public function getMatchedInfluencers($id)
    {
        $data = Ad::findOrFail($id);
        if($data->status !== 'prepay') return response()->json([
            'err'=>trans($this->trans_dir.'ad_doesn\'t_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        $infData = $data->matches()->where('chosen',1)->get()->map(function($item){
            $inf = $item->influencers;
            //Todo add AOAF OR ROAS
            return [
                'name'  => $inf->nick_name,
                'match' => $item->match
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched_under_budget'),
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    // Get unmatched influencers
    public function getMatchedInfluencersNotChosen($campaign_id,$removed_inf_id,Request $request)
    {

        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'err'=>trans($this->trans_dir.'ad_not_found'),
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));
        }

        if($ad->status !== 'prepay' && $ad->status != 'choosing_influencer'){
            return response()->json([
                'err'       => trans($this->trans_dir.'ad_dont_have_right_status'),
                'status'    => config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        if($removed_inf_id == -1){
            $infData =$ad->matches();
            if($request->search)
            {
               $infData = $infData->whereHas('influncers',function($q) use($request){
                    $q->where('nick_name','%'.$request->search.'%');
                });
            }
            $infData = $infData->where([['chosen',0],['status','!=','deleted']])->get()->map(function($item) use($ad){
                $influencerPrice = $ad->onSite ? $item->influencers->ad_onsite_price_with_vat : $item->influencers->ad_onsite_price_with_vat;
                $isProfitable = $ad->campaignGoals->profitable;

                $remainingBudget = $ad->budget - $ad->price_to_pay;

                $response =  [
                    'id'        => $item->influencers->id,
                    'name'      => $item->influencers->nick_name,
                    'image'     => $item->influencers->users->InfulncerImage ? $item->influencers->users->InfulncerImage : null,
                    'match'     => $item->match,
                    'gender'    => trans($this->trans_dir.$item->influencers->gender),
                    'budget'    => number_format($influencerPrice),
                    'status'    => $item->status,
                    'eligible'  => $remainingBudget >= $influencerPrice
                ];
               
                $response['ROAS'] = null;
                $response['engagement_rate'] = null;
                $response['AOAF'] = null;

                if($isProfitable){
                    $response['ROAS'] = $item->match . '%';
                }else{
                    $response['engagement_rate'] = $item->match . '%';
                    $response['AOAF'] = $item->AOAF;
                }

                return $response;
            });


            return response()->json([
                'msg'       => trans($this->trans_dir.'all_matched_under_budget'),
                'data'      => $infData,
                'status'    => config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }

        $ReplacedInfluencer = Influncer::find($removed_inf_id);
        if (!$ReplacedInfluencer) {
            return response()->json([
                'msg' => 'Influencer not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $infData =$ad->matches();
            if($request->search)
            {
               $infData = $infData->whereHas('influencers',function($q) use($request){
                    $q->where('nick_name','%'.$request->search.'%');
                });
            }
            $infData = $infData->where('chosen',0)->get()->map(function($item) use($ad , $ReplacedInfluencer){
			$remainingBudget = $ad->budget - $ad->price_to_pay;
            $influencerPrice = $ad->onSite ? $item->influencers->ad_onsite_price_with_vat : $item->influencers->ad_onsite_price_with_vat;

            $isProfitable = $ad->campaignGoals->profitable;

            $response =  [
                'id'        => $item->influencers->id,
                'name'      => $item->influencers->nick_name,
                'image'     => $item->influencers->users->InfulncerImage ? $item->influencers->users->InfulncerImage : null,
                'match'     => $item->match,
                'gender'    => trans($this->trans_dir.$item->influencers->gender),
                'budget'    => number_format($influencerPrice),
                'status'    => $item->status,
                'eligible'  => $remainingBudget >= $influencerPrice
            ];
           
            $response['ROAS'] = null;
            $response['engagement_rate'] = null;
            $response['AOAF'] = null;

            if($isProfitable){
                $response['ROAS'] = $item->match . '%';
            }else{
                $response['engagement_rate'] = $item->match . '%';
                $response['AOAF'] = $item->AOAF;
            }

            return $response;
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched_under_budget'),
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    //Change influencers match
    public function replace_matched_influencer($ad_id , $removed_inf_id , $chosen_inf_id)
    {
        $ad = Ad::find($ad_id);

        $chosen_inf = Influncer::find($chosen_inf_id);
        $chosenInfPrice = $ad->onSite ? $chosen_inf->ad_onsite_price_with_vat : $chosen_inf->ad_with_vat;

        if (!$chosen_inf) {
            return response()->json([
                'err'=>trans($this->trans_dir.'chosen_influencer_data_not_found'),
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));
        }
        

        $removed_inf = Influncer::find($removed_inf_id);
        $oldInfPrice = $ad->onSite ? $removed_inf->ad_onsite_price_with_vat : $removed_inf->ad_with_vat;

        if (!$removed_inf) {
            return response()->json([
                'err'=>trans($this->trans_dir.'influencer_data_not_found'),
                'status'=> false
            ],config('global.NOT_FOUND_STATUS'));
        }

        $remainingBudget = $ad->budget - $ad->price_to_pay;
        $chosenInfPrice -= $remainingBudget;

        if ($chosenInfPrice > $oldInfPrice) {
            return response()->json([
                'msg' => 'You don\'t have enough budget to replace this influencer',
                'status' => 401,
            ], 401);
        }

        $changeOld = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $removed_inf_id]])->first();
        $changeOld->chosen = 0;
        $changeOld->status = 'not_basic';
        $changeOld->save();

        $changeNew = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $chosen_inf_id]])->first();
        $changeNew->chosen = 1;
        $changeNew->status = 'not_basic';
        $changeNew->save();

        $this->calculateCampaignPrice($ad);

        return $this->match_response($ad);
    }

    //Calculate Campaign price
    private function calculateCampaignPrice($ad){
        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $budgetSum = 0;
        foreach($matchedInfluencers as $match){
            $price = $ad->ad_type == 'online' ? $match->influencers->ad_with_vat : $match->influencers->ad_onsite_price_with_vat;
            $budgetSum += $price;
        }

        $relation = $ad->relations ? $ad->relations->app_profit : 10;
        $budgetSum += $relation / 100 * $budgetSum;

        $ad->update(['price_to_pay' => $budgetSum]);
    }
    
    //Todo Explain this
    public function before_payment($id)
    {
        $data = Ad::find($id);
        
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $cal = $data->budget * 5.5 / 100;

        if($data->status !== 'approve') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        // dd(Auth::user()->customers);
        $name = Auth::guard('api')->user()->customers->full_name;
        $info =[
            'msg' => trans($this->trans_dir.'customer') . " $name " . trans($this->trans_dir.'payed_five_percent') . " ($cal) " . trans($this->trans_dir.'for') . " " . $data->store,
            'id' => $data->id,
            'type' => 'Ad'
        ];

        $this->sendAdminNotification('contract_manager_notification',$info);

        $getContactManagers = User::whereHas('roles',function($q){
            $q->where('name','Contracts Manager')
            ->orWhere('name','superAdmin');
        })->get();

        Notification::send($getContactManagers, new AddInfluencer($info));
        
        $isProfitable =  $data->campaignGoals->profitable;
        $isOnSite = $data->ad_type == 'onsite';

        return response()->json([
            'msg' => trans($this->trans_dir.'all_matched_blurred'),
            'data' => [
                'type ' => trans($this->trans_dir.$data->type),
                'category' => $data->categories ? $data->categories->name : null,
                'format_price' => $this->formateMoneyNumber($cal),
                'format_budget' => $this->formateMoneyNumber($data->budget),
                'price' => $cal,
                'budget' => $data->budget,
                'matches' => $data->matches()->where('status','!=','deleted')->get()->map(function($item) use($isProfitable,$isOnSite){
                    $price = $isOnSite ? $item->influencers->ad_onsite_price_with_vat : $item->influencers->ad_with_vat;
                    $response = [
                        'id'            => $item->influencers->id,
                        'match'         => $item->match,
                        'gender'        => trans($this->trans_dir.$item->influencers->gender),
                        'is_primary'    => $item->status == 'basic' ? true : false,
                        'budget'        => number_format($price)
                    ];

                    $response['ROAS'] = null;
                    $response['engagement_rate'] = null;
                    $response['AOAF'] = null;
                    
                    if($isProfitable){
                        $response['ROAS'] = $item->match . '%';
                    }
                    else{
                        $response['engagement_rate'] = $item->match  . '%';
                        $response['AOAF'] = $item->AOAF;
                    }

                    return $response;
                })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    /** NOT IN USE */
    //Todo Remove
    public function pay_now($id)
    { 
        $data = Ad::find($id);

        if(!$data) return response()->json([
            'err' => trans($this->trans_dir.'ad_not_found'),
            'status' => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($data->status !== 'approve' && $data->status !=='prepay') return response()->json([
            'err' => trans($this->trans_dir.'ad_don\'t_have_right_status'),
            'status' => config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        
        $cal = $data->budget * 5.5 / 100;

        return response()->json([
            'msg' => trans($this->trans_dir.'all_matched'),
            'data' => [
				'id' => $data->id,
                'type' => trans($this->trans_dir.$data->type),
                'category' => $data->categories?$data->categories->name:null,
                'price' => $data->budget - $cal,
                'budget' => $data->budget,
                'match' => $data->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item) use($data){
                    $response = [
                        'id'        => $item->influencers->id,
                        'name'      => $item->influencers->nick_name,
                        'image'     => $item->influencers->users->InfulncerImage ? $item->influencers->users->InfulncerImage : null,
                        'match'     => $item->match,
                        'status'    => $item->status
                    ];

                    $isOnSite = $data->ad_type == 'onsite';

                    $response['ROAS'] = null;
                    $response['engagement_rate'] = null;
                    $response['AOAF'] = null;
                    
                    if($isProfitable){
                        $response['ROAS'] = $item->match  . '%';
                    }else{
                        $response['engagement_rate'] = $item->match  . '%';
                        $response['AOAF'] = $item->AOAF;
                    }

                    return $response;
                })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    //Todo Explain this
    public function back_up_influencers($id,$removed_inf)
    {
        $data = Ad::find($id);
        $user = User::find($removed_inf);

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(!$user||!$user->influncers) return response()->json([
            'err'=>trans($this->trans_dir.'inf_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
		
        $inf = $user->influncers;

        $alldata = $data->matches()->where(['status','!=','deleted'])->where('chosen',0)->get()->map(function($item) use($inf,$data,$removed_inf){
            $chosenInf = $data->onSite ?$inf->ad_onsite_price:$inf->ad_price;
            $oldInf = $data->ad_type == 'onsite' ? User::find($removed_inf)->influncers->ad_onsite_price:User::find($removed_inf)->influncers->ad_price;
            $newBud = $data->budget + $chosenInf - $oldInf;

            return[
                'type' => trans($this->trans_dir.$data->type),
                'category' => $data->categories->name,
                'eligible' => $newBud < $data->budget ? true : false,
            ];
        });
        return response()->json([
            'msg'=>trans($this->trans_dir.'unchosen_match'),
            'data'=>$alldata,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    /** When the influencer response to the ad */
    //Todo check notification
    public function completeAd($contract_id)
    {
        /** FIND THE CONTRACT */
        $data = InfluencerContract::find($contract_id);

        if(!$data) return response()->json([
            'msg'=>trans($this->trans_dir.'contract_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        
        /** FIND THE INFLUENCER  */
        $influencer = Influncer::find($data->influencer_id);

        if(!$influencer) return response()->json([
            'msg'=>trans($this->trans_dir.'inf_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        /** FIND THE AD  */
        $ad = Ad::find($data->ad_id);
        
        if(!$ad) return response()->json([
            'msg'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));


        $name = $influencer->nick_name;
        $info =[
            'msg'=>trans($this->trans_dir.'influencer').' "'.$name.'"'. trans($this->trans_dir.'completed_small') .'"'.$ad->store.'" ad',
            'id'=>$ad->id,
            'type'=>'Ad'
        ];

      /** FIND THE CONTRACT ADMINS  */
        $getContactManagers = User::whereHas('roles',function($q){
            $q->where('name','Contracts Manager')
            ->orWhere('name','superAdmin');
        })->get();

        $this->sendAdminNotification('contract_manager_notification',$info);
        Notification::send($getContactManagers, new AddInfluencer($info));

        /** CONTRACT ACCEPT*/
        $data->status = 1;
        $data->save();

        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    //Customer Approve/Reject contract
    public function accept_customer_ad_contract(Request $request , $contract_id)
    {
        $data = CampaignContract::find($contract_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'contract_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($request->status == 0&&!$request->rejectNote) return response()->json([
            'err'=>trans($this->trans_dir.'please_add_reject_note'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $data->is_accepted = $request->status;
        $data->rejectNote = $request->status == 0 ? $request->rejectNote : null;
        $data->save();

        $adData = [
            'budget' => number_format($data->ads->budget),
            'price_to_pay' => number_format($data->ads->price_to_pay),
            'price' => $data->ads->price_to_pay,
        ];
    
        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'data' => $adData,
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    //Add new influencer to match list
    public function addMatch(Request $request)
    {
        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();
        $addInf = Influncer::find($request->influncer_id);

        if(!$data) return response()->json([
            'err'       => trans($this->trans_dir.'influencer_match_was_not_found'),
            'status'    => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $ad = Ad::find($request->ad_id);

        if(!$ad) return response()->json([
            'err'       => trans($this->trans_dir.'ad_not_found'),
            'status'    => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $remainingBudget = $ad->budget - $ad->price_to_pay;

        $chosenInfBudget = $ad->ad_type == 'onsite' ? $addInf->ad_onsite_price : $addInf->ad_price;

        if($remainingBudget < $chosenInfBudget){
            return response()->json([
                'msg' => trans($this->trans_dir.'Your budget didn\'t enough to add a new influencer'),
                'status' => config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        
        
        $data->chosen = 1;
        $data->status = 'not_basic';
        $data->save();

        return $this->match_response($ad);

    }

    //Change the match Status (Basic, Not Basic)
    public function changeMatchStatus(Request $request)
    {

        $ad = Ad::findOrFail($request->ad_id);
        
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'match_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->status = $request->status;
        $data->save();

       
        return $this->match_response($ad);
    }

    //Return Influencers mathces before customer pay full payment
    public function get_ad_influencers_match($ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        
        $cal = $data->budget * 5.5 / 100;

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched'),
            'data'=>[
                'id'                => $data->id,
                'type'              => trans($this->trans_dir.$data->type),
                'status'            => $data->status,
                'influncers_status' => $data->admin_approved_influencers ? true : false,
                'category'          => $data->categories?$data->categories->name:null,
                'price'             => $data->price_to_pay,
                'budget'            => $data->budget,
                'format_price'      => $this->formateMoneyNumber($data->budget - $cal),
                'format_budget'     => $this->formateMoneyNumber($data->budget),
                'match'             => $this->get_ad_influencers_matchs($data)
            ],
            'status' => config('global.OK_STATUS')
        ],config('global.OK_STATUS'));


    }

    //Check the payment after customer pay full or first payment
    public function check_payment(CheckPaymentRequest $request ,$ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
       // return dd('here');
        if((string)$request->ResponseCode !== '000')
        {
            /**
            * 
             * Save in the database
             * 
             */
            Payment::create([
                'ad_id' => $ad_id,
                'trans_id' => $request->TranId,
                'amount' => $request->amount,
                'status' => $request->result,
                'status_code' => $request->ResponseCode,
                'type' => $request->type,
            ]);

            /**
             * Send notification to customer when the payment failed
             */
            $tokens = [ $data->customers->users->fcm_token ];

            $data = [
                "title" =>trans($this->trans_dir_notification.'reject_payment_ad_title'),
                "body" => trans($this->trans_dir_notification.'reject_payment_ad',['ad_name'=>$data->store]),
                "type" => 'Ad',
                'target_id' =>$ad->id
            ];
			$this->sendNotifications($tokens,$data);
             return response()->json([
                'err' => trans($this->trans_dir.'payment_failed'),
                'status' => config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        $terminalId = config('global.PAYMENT_USERNAME');
        $password = config('global.PAYMENT_PASSWORD');
        $key = config('global.PAYMENT_KEY');
        $requestHash = "" . $request->TranId . "|" . $key . "|" . $request->ResponseCode . "|" . $request->amount . "";
        $txn_details1 = "" . $ad_id . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $request->amount . "|SAR";
		
        $hash = hash('sha256', $requestHash);
       
        $txn_details1 = "" . $ad_id . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $request->amount . "|SAR";

        //Secure check
        $requestHash1 = hash('sha256', $txn_details1);
        $apiFields    = array(
            'trackid' => $ad_id,
            'terminalId' => $terminalId,
            'action' => '10',
            'merchantIp' => "",
            'password' => $password,
            'currency' => "SAR",
            'transid' => "",
			'transid' => $request->TranId,
            'amount' => $request->amount,
            'udf5' => "",
            'udf3' => "",
            'udf4' => "",
            'udf1' => "",
            'udf2' => "",
            'requestHash' => $requestHash1
        );
        
        $apiFieldsString = json_encode($apiFields);
        
        $url = "https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest";
        $ch  = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $apiFieldsString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($apiFieldsString)
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        //execute post
        $apiResult = curl_exec($ch);
    
        $apiResult = json_decode($apiResult);

        if($apiResult->result == 'Successful' || $apiResult->responseCode == '000'){
            
            if($request->type == 'sub_payment'){
                $data->update(['status' => 'prepay']);
            }else if($request->type == 'full_payment'){
                $data->update(['status' => 'fullpayment']);

                $tokens = [];
                foreach($data->matches as $match){
                    $tokens[] = $match->influencers->users->fcm_token;
                }

                if(!empty($tokens)){
                    $title = trans($this->trans_dir.'new_campaign_request');
                    $msg = trans($this->trans_dir.'new_campaign_request_msg',[":name" => $data->store]);
                
                    $data = [
                        "title"     => $title,
                        "body"      => $msg,
                        "type"      => 'Ad',
                        'target_id' => $data->id
                    ];
    
                    $this->sendNotifications($tokens,$data);
                }
                
            }
            
            Payment::create([
                'ad_id' => $ad_id,
                'trans_id' => $request->TranId,
                'amount' => $request->amount,
                'status' => $request->result,
                'status_code' => $request->ResponseCode,
                'type' => $request->type,
            ]);

            return response()->json([
                'msg' => trans($this->trans_dir.'payment_successfully'),
                'ad_status' => $data->status,
                'status' => config('global.OK_STATUS'),
            ],config('global.OK_STATUS'));
        }
    
        return response()->json([
            'err'=>trans($this->trans_dir.'payment_failed'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
    }

    //Confirm Influencers By the customer
    public function confirm_matches($ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($data->status != 'prepay')
        {
            return response()->json([
                'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        $data->status = 'choosing_influencer';
        $data->save();

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>trans($this->trans_dir.'data_was_updated')
        ],config('global.OK_STATUS'));

    }

    //Update Campaign Data 
    public function update(Request $request , $ad_id)
    {
        #GET THE AD AND CHECK IF THE AD EXIST
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        
        if(gettype($request->social_media) == 'array' && count($request->social_media) > 0)
        {
            DB::table('social_media_id')->where('ad_id',$data->id)->delete();

            foreach ($request->social_media as $value) {
                DB::table('social_media_id')->insert([
                   'ad_id'=>$data->id,
                   'social_media_id'=>$value['type']??$value->type,
                   'link'=>$value['link']??$value->type
                ]);
			
            }
        }
        $arr = array_merge($request->all(),['status'=>'pending']);

        if($data->update($arr))
        {
            return response()->json([
                'msg'=>trans($this->trans_dir.'ad_was_updated'),
                'data'=>$data,
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }
        else
        {
            return response()->json([
                'err'=>trans($this->trans_dir.'something_wrong'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
    }

    public function ad_details_update($ad_id)
    {
        #GET THE AD AND CHECK IF THE AD EXIST
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'data' => $data,
            'status' => config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    //Match influencers list 
    private function match_response($ad)
    {
        $matches = $ad->matches()->where('chosen', 1)->where('status','!=','deleted')->get();
        $hasInfluencerError = false;
        foreach($matches as $match){
            if(!$match->contract || !$match->contract->date || !$match->contract->scenario){
                $hasInfluencerError = true;
                break;
            }
        }
        $admin_approved_influencers = $ad->admin_approved_influencers == 1 && !$hasInfluencerError;

        return response()->json([
            'msg'       => trans($this->trans_dir.'data_was_updated'),
            'status'    => config('global.OK_STATUS'),
			'data' => [
				'id'                => $ad->id,
				'type'              => $ad->type,
				'status'            => $ad->status,
                'influncers_status' => $admin_approved_influencers ? true : false,
				'category'          => $ad->categories->name,
				'format_budget'     => $this->formateMoneyNumber($ad->budget),
				'budget'            => $ad->budget,
				'match'             => $this->get_ad_influencers_matchs($ad)
            ]
            ],config('global.OK_STATUS')
        );
    }

    //Get Influencers Matches data
    private function get_ad_influencers_matchs($ad)
    {
       $isProfitable =  $ad->campaignGoals->profitable;
       $isOnSite = $ad->ad_type == 'onsite';
        return $ad->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item) use($isProfitable,$isOnSite,$ad){
            $price = $isOnSite ? $item->influencers->ad_onsite_price_with_vat : $item->influencers->ad_with_vat;

            $contract = InfluencerContract::where('influencer_id', $item->influencer_id)->where('ad_id',$ad->id)->first();

            $influencerPrice = $ad->onSite ? $item->ad_onsite_price_with_vat : $item->influencers->ad_onsite_price_with_vat;

            $status = null;

            $response = [
                'id'            => $item->influencers->id,
                'name'          => $item->influencers->nick_name,
                'image'         => $item->influencers->users->InfulncerImage ? $item->influencers->users->InfulncerImage : null,
                'gender'        => trans($this->trans_dir.$item->influencers->gender),
                'is_primary'    => $item->status == 'basic' ? true : false,
                'budget'        => number_format($price),
                'status'        => null
            ];

            $response['ROAS']               = null;
            $response['engagement_rate']    = null;
            $response['AOAF']               = null;
            if($isProfitable)
            {
                $response['ROAS'] = $item->match . '%';
            }
            else
            {
                $response['engagement_rate']    = $item->match . '%';
                $response['AOAF'] = $item->AOAF;
            }

            $response['start_date'] = null;
            if($contract && $contract->date){
                $response['start_date'] = $contract->date->format('d/m/Y');
            }

            return $response;
        });
    }

    private function onSiteValidation($request)
    {
        if($request->has_marouf_num && !$request->marouf_num)
        {
            return trans($this->trans_dir.'please_add_a_marouf');
        }
        elseif(!$request->has_marouf_num && !$request->cr_num)
        {
            return trans($this->trans_dir.'please_add_cr_number');
        }
        elseif(!$request->has_marouf_num && !$request->cr_image)
        {
            return trans($this->trans_dir.'please_add_cr_image');
        }
        elseif($request->has_online_store && !$request->store_link)
        {
            return trans($this->trans_dir.'please_add_store_link');
        }
		  elseif($request->has_offer && !$request->offer > 0)
        {
            return trans($this->trans_dir.'please_add_offer');
        }
		  elseif(!$request->prefered_media_id)
        {
            return trans($this->trans_dir.'please_add_an_prefered_media_id');
        }
		  elseif($request->has_marouf_num == 1 && !$request->marouf_num)
        {
            return trans($this->trans_dir.'please_add_an_marouf_number');
        }
		  elseif($request->has_marouf_num == 0 && !$request->cr_num)
        {
            return trans($this->trans_dir.'please_add_an_cr_number');
        }
		  elseif($request->has_marouf_num == 0 && !$request->cr_image)
        {
            return trans($this->trans_dir.'please_add_an_cr_image');
        }


        return false;
    }

    public function uploadMedia(UploadAdMedia $request , $file_id , $type){

        /**
         * type:
         * Add 
         * Remove
         * Replace
         */
        
        # IF THE FILE ID IS -1 IT WILL ADD A FILE
        if($type == 'add')
        {

            if(!$request->ad_id)
            {
                return response()->json([
                    'err'=>trans($this->trans_dir.'please_add_th_ad_id'),
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }
            if(!$request->file_type)
            {
                return response()->json([
                    'err'=>trans($this->trans_dir.'please_add_the_file_type'),
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }

        }


        if($type == 'remove')
        {
           $media =  DB::table('media')->where('id',$file_id)->where('model_type','App\Models\Ad')->first();

           if(!$media)
           {
               return response()->json([
                   'err'=>'file was not found',
                   'status'=>config('global.NOT_FOUND_STATUS')
               ],config('global.NOT_FOUND_STATUS'));
           }
 
           DB::table('media')->where('id',$file_id)->where('model_type','App\Models\Ad')->delete();

            return response()->json([
                'err'=>'file was removed',
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS')); 

        };
        if($type == 'replace')
        {
            $media = DB::table('media')->where('id',$file_id)->where('model_type','App\Models\Ad')->first();


            if(!$media)
            {
                return response()->json([
                    'err'=>'file was not found',
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }

            $ad = Ad::find($media->model_id);

            if(!$ad)
            {
                return response()->json([
                    'err'=>trans($this->trans_dir.'ad_not_found'),
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }

            $file = $ad->addMedia($request->file)
            ->toMediaCollection($media->collection_name);

            DB::table('media')->where('id',$file_id)->where('model_type','App\Models\Ad')->delete();

            return response()->json([
                'msg'=>'file was uploaded',
                'data'=>[
                    'id'=>$file->id,
                    'url'=>$file->getFullUrl(),
                ],
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));

        }
        else
        {
           $ad = Ad::find($request->ad_id);
           
            if(!$ad) return response()->json([
                'err'=>trans($this->trans_dir.'ad_not_found'),
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));

            $ad->addMedia($request->file)
            ->toMediaCollection($request->file_type);

            $mediaItems = $ad->getMedia($request->file_type);
            $publicFullUrl = [];
            if(count($mediaItems) > 0)
            {
                foreach($mediaItems as $item)
                {
                    $obj = (object)[
                        'id'=>$item->id,
                        'url'=>$item->getFullUrl()
                    ];
                    // $publicFullUrl = $item->getFullUrl();
                    array_push($publicFullUrl,$obj);
                }
                
            }

            return response()->json([
                'msg'=>'file was uploaded',
                'data'=>$publicFullUrl[count($mediaItems) - 1],
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }

    }

    //Get Media Gallery for Influencer
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

    //Delete Media Gallery For Influencer
    function deleteGalleryMedia($id){
        $media = DB::table('media')->where('id',$id)->where('model_type','App\Models\Influncer')->first();
        
        if(!$media)return response()->json([
            'err' => trans($this->trans_dir.'file_not_found'),
            'status' => config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $model_type = $media->model_type;
        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);

        return response()->json([
            'msg'       => trans($this->trans_dir.'media_deleted_successfully'),
            'status'    => true,
        ],200);
    }

    //Get relations for Campaign
    public function get_ads_relation()
    {
      $relations = Relation::get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->title
            ];
      });

        return response()->json([
            'msg'       => trans($this->trans_dir.'all_relation'),
            'data'      => $relations,
            'status'    => config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    private function formateMoneyNumber($number)
    {
        return number_format($number,0,'.',',');
    }
    
    
}
