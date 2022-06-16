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
use App\Models\Influncer;
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

            $data = Auth::guard('api')->user()->influncers->contracts();

            if($status == 'Completed'){
                $itemsPaginated =  $data
                ->where('status',1)
                ->orderBy('created_at','desc')
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            elseif($status == 'Active')
            {
                $itemsPaginated =  $data
                ->where('status',0)
                ->orderBy('created_at','desc')
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            elseif($status == 'Pending')
            {
                $itemsPaginated =  $data
                ->where('status',0)
                ->where('is_accepted',$statusCode[$status])
                ->orderBy('created_at','desc')
                ->paginate(10);
            }
            elseif($status == 'Rejected')
            {
                $itemsPaginated =  $data
                ->where('status',0)
                ->orderBy('created_at','desc')
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            else
            {
                $itemsPaginated = $data->orderBy('created_at','desc')
                ->paginate(10);
            };
          

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

    public function store(AdRequest $request)
    {
        #CHECK REQUEST 
        if(!$request->hasFile('commercial_doc')&&!$request->has_marouf_num)
        {
            return response()->json([
                'err'=>trans($this->trans_dir.'upload_doc_or_add_auth_num'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        $data = array_merge($request->all(),['customer_id'=>Auth::guard('api')->user()->customers->id]);

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
        $this->create_customer_contract($data->id,Auth::guard('api')->user()->customers);
         #CHECK IF THERE IS A CONTRACT IN THE DATABASE
         if(!$this->create_contract($data->id,Auth::guard('api')->user()->customers)) return response()->json([
            'err'=>trans($this->trans_dir.'no_contract_in_system'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

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

      //  $this->sendAdminNotification('contract_manager_notification',$info);

       // $c_not = Notification::send($getAdmin, new AddInfluencer($info));

        return response()->json([
            'msg'=>trans($this->trans_dir.'ad_was_created'),
            'data'=>$this->adResponse($data),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function details($id)
    {
        $data = Ad::find($id);

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'=>trans($this->trans_dir.'ad_details'),
            'data'=>$this->adResponse($data),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function get_ad_contract($ad_id)
    {
        $ad = Ad::find($ad_id);
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(!$ad||$ad->status == 'pending'||$ad->status == 'rejected') return response()->json([
            'err'=>trans($this->trans_dir,'no_contract_for_ad').' '.$ad->status,
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        $data = CampaignContract::select(['content'])->find($ad->contacts->id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'contract_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>trans($this->trans_dir.'ad_contract'),
            'data'=>$data->content,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function accept_ad_contract(AcceptAdContractRequest $request,$contract_id)
    {
        $data = InfluencerContract::find($contract_id);

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'contract_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->is_accepted = $request->status == 0?2:$request->status;
        $data->rejectNote = $request->reject_note;
        $data->save();

        if($request->status == 0&&$request->rejectNote)
        {
            $influencer = Influncer::find($data->influencer_id);
            $name = $influencer->first_name.' '.$influencer->middle_name.' '.$influencer->last_name;
            
            $info =[
                'msg'=>trans($this->trans_dir.'influencer').'"'.$name.'"'. trans($this->trans_dir.'reject_contract') .'"'.$data->rejectNote.'"'.' '.trans($this->trans_dir.'ad_small'),
                'id'=>$influencer->users->id,
                'type'=>'Influencer'
            ];

            $this->sendAdminNotification('contract_manager_notification',$info);

            $getContactManagers = User::whereHas('roles',function($q){
                $q->where('name','Contracts Manager')
                ->orWhere('name','superAdmin');
            })->get();

            Notification::send($getContactManagers, new AddInfluencer($info));

        }

        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function search($query)
    {
        $user_id = Auth::guard('api')->user()->influncers ? Auth::guard('api')->user()->influncers->id :Auth::guard('api')->user()->customers->id;

        if(Auth::guard('api')->user()->influncers)
        {
            $data = Auth::guard('api')->user()->influncers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
        }
        else
        {
            $data = Auth::guard('api')->user()->customers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
        }

        $data->getCollection()->transform(function($item){
             return $this->adResponse($item);
        });
        return response()->json([
            'msg'=>trans($this->trans_dir.'search_result'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ]);
    }

    public function get_influencer_ads($influencer_id,$status = null)
    {
        $data = Influncer::find($influencer_id);
        $itemsPaginated  = [];
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'inf_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($status)
        {
          $itemsPaginated  =  $data->ads()->where('status',$status)->paginate(config('global.PAGINATION_NUMBER'));

        }
        else
        {
            $itemsPaginated  = $data->ads()->paginate(config('global.PAGINATION_NUMBER'));
        }


        $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item){
            return $this->adResponse($item);

        })->toArray();


        return response()->json([
            'msg'=>trans($this->trans_dir.'all_inf_ads'),
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function get_customers_ads($customer_id , $status = null)
    {
        $data = Customer::find($customer_id);
        $itemsPaginated  = [];
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'customer_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($status)
        {
          $itemsPaginated  =  $data->ads()->where('status',$status)->paginate(config('global.PAGINATION_NUMBER'));

        }
        else
        {
            $itemsPaginated  = $data->ads()->paginate(config('global.PAGINATION_NUMBER'));
        }

        $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item){
            return $this->adResponse($item);
        })->toArray();

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_customer_ads'),
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function getMatchedInfluencers($id)
    {
        $data = Ad::findOrFail($id);
        if($data->status !== 'prepay') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        $infData = $data->matches()->where('chosen',1)->get()->map(function($item){
            $inf = $item->influencers;
            return [
                'name'=>$inf->full_name,
                'match'=>$item->match
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched_under_budget'),
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function getMatchedInfluencersNotChosen($id,$removed_inf_id,$replace_permission = null)
    {
        $data = Ad::find($id);
        $info = Influncer::find($removed_inf_id);

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($removed_inf_id == -1)
        {

            $infData = $data->matches()->where([['chosen',0],['status','!=','deleted']])->get()->map(function($item) use($data , $info){

                $currentInf = Influncer::find($item->influencer_id);
                $eligible = 0;
                $currentBudget = 0;
                $counter = 0;
                $test = [];

                if($data->onSite)
                {
                    $currentBudget = ($currentInf->ad_onsite_price >= $item->influencers->ad_onsite_price)?1:0;
                }
                else
                {
                    $currentBudget = ($currentInf->ad_price >= $item->influencers->ad_price)?1:0;
                }
                $counter = $counter +1;

                return $this->match_influencer_with_eligible_status($item->influencers,$item,$counter == 2?:$currentBudget,$item->status);
            });

            return response()->json([
                'msg'=>trans($this->trans_dir.'all_matched_under_budget'),
                'data'=>$infData,
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }

        if(!$info) return response()->json([
            'err'=>trans($this->trans_dir.'inf_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
      
        if(!$replace_permission&&$data->status !== 'prepay'&&$data->status !== 'choosing_influencer') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));


		
        $infData = $data->matches()->where('chosen',0)->get()->map(function($item) use($data , $info){
			
            $currentInf = $info;
            $eligible = 0;
            $currentBudget = 0;
			$counter = 0;
			$test = [];

			

            if($data->onSite)
            {
                $currentBudget = ($currentInf->ad_onsite_price >= $item->influencers->ad_onsite_price)?1:0;
				
            }
            else
            {

                $currentBudget = ($currentInf->ad_price >= $item->influencers->ad_price)?1:0;
            }
			$counter = $counter +1;
			

            return $this->match_influencer_with_eligible_status($item->influencers,$item,$counter == 2?:$currentBudget,$item->status);
            
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched_under_budget'),
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function replace_matched_influencer($id , $removed_influencer , $chosen_influencer)
    {
        $removeFromChosen = AdsInfluencerMatch::where([['ad_id',$id],['influencer_id',$removed_influencer]])->first();

        if(!$removeFromChosen) return response()->json([
            'err'=>trans($this->trans_dir.'data_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
		
        $removeFromChosen->chosen = 0;
        $removeFromChosen->save();

        $addToChosen = AdsInfluencerMatch::where([['ad_id',$id],['influencer_id',$chosen_influencer]])->first();
        if(!$addToChosen) return response()->json([
            'err'=>trans($this->trans_dir.'data_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $addToChosen->chosen = 1;
        $addToChosen->status = 'not_basic';
        $addToChosen->save();
        $data = Ad::findOrFail($id);

        return $this->match_response($data);

    //     return response()->json([
    //         'msg'=>trans($this->trans_dir.'data_was_updated'),
	// 		'data'=>[
    //             'id'=>$data->id,
	// 			'type'=>$data->type,
	// 			'category'=>$data->categories->name,
	// 			'budget'=>$data->budget,
	// 			'match'=>$this->get_ad_influencers_matchs($data)
    //         ],
    //     'status'=>config('global.OK_STATUS')
    //    ],config('global.OK_STATUS'));


    }
    
    public function before_payment($id)
    {
        $data = Ad::find($id);
        
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $cal = $data->budget*5.5/100;

        if($data->status !== 'approve') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

       // dd(Auth::user()->customers);
        $name = Auth::guard('api')->user()->customers->first_name.' '.Auth::guard('api')->user()->customers->middle_name.' '.Auth::guard('api')->user()->customers->last_name;
        $info =[
            'msg'=>trans($this->trans_dir.'customer').' '.'."'.$name.'"'.trans($this->trans_dir.'payed_five_percent').'('.$cal.')'. trans($this->trans_dir.'for') .'"'.$data->store.'" ',
            'id'=>$data->id,
            'type'=>'Ad'
        ];

        // $this->sendAdminNotification('contract_manager_notification',$info);

        // $getContactManagers = User::whereHas('roles',function($q){
        //     $q->where('name','Contracts Manager')
        //     ->orWhere('name','superAdmin');
        // })->get();

        // Notification::send($getContactManagers, new AddInfluencer($info));
        
        

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched_blurred'),
            'data'=>[
                'type'=>$data->type,
                'category'=>$data->categories ? $data->categories->name : null,
                'price'=>$cal,
                'budget'=>$data->budget,
                'matches'=>$data->matches()->where('status','!=','deleted')->get()->map(function($item){
                    return $item->match;
                })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    /** NOT IN USE */
    public function pay_now($id)
    { 
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($data->status !== 'approve'&&$data->status !=='prepay') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        
        $cal = $data->budget*5.5/100;

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched'),
            'data'=>[
				'id'=>$data->id,
                'type'=>$data->type,
                'category'=>$data->categories?$data->categories->name:null,
                'price'=>$data->budget - $cal,
                'budget'=>$data->budget,
                'match'=> $data->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item){
                        return [
							'id'=>$item->influencers->id,
                            'name'=>$item->influencers->first_name.' '.$item->influencers->middle_name.' '.$item->influencers->last_name,
                            'image'=>$item->influencers->users->InfulncerImage?$item->influencers->users->InfulncerImage:null,
                            'match'=>$item->match,
                            'status'=>$item->status
                        ];
                    })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

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
                'type'=>$data->type,
                'category'=>$data->categories->name,
                'eligible'=>$newBud < $data->budget?true:false,
            ];
        });
        return response()->json([
            'msg'=>trans($this->trans_dir.'unchosen_match'),
            'data'=>$alldata,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    /** NOT IN USE */
    public function full_payment($ad_id)
    {
        $ad = Ad::find($ad_id);
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        
        if($ad->status !== 'prepay') return response()->json([
            'err'=>trans($this->trans_dir.'ad_dont_have_right_status'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $ad->status = 'fullpayment';
        $ad->save();

        $name = Auth::guard('api')->user()->customers->first_name.' '.Auth::guard('api')->user()->customers->middle_name.' '.Auth::guard('api')->user()->customers->last_name;
        $info =[
            'msg'=>trans($this->trans.'customer').' "'.$name.'"'.' '.trans($this->trans.'payed_full_payment').'('.$ad->budget.') for "'.$ad->store.'" ',
            'id'=>$ad->id,
            'type'=>'Ad'
        ];

        $this->sendAdminNotification('contract_manager_notification',$info);

        $getContactManagers = User::whereHas('roles',function($q){
            $q->where('name','Contracts Manager')
            ->orWhere('name','superAdmin');
        })->get();

        Notification::send($getContactManagers, new AddInfluencer($info));
        

        return response()->json([
            'msg'=>trans($this->trans_dir.'ad_status_was_changed').$ad->status.'',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }


    /** When the influencer response to the ad */
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


        $name = $influencer->first_name.' '.$influencer->middle_name.' '.$influencer->last_name;
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
        $data->rejectNote = $request->status == 0?$request->rejectNote:null;
        $data->save();
    
        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function addMatch(Request $request)
    {
        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();
        $addInf = Influncer::find($request->influncer_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'influencer_match_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $ad = Ad::find($request->ad_id);
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $budget = $ad->budget;
        $matches = $ad->matches;
        $allInfPrices = 0;

        foreach ($matches as $value) {
           $inf = Influncer::find($value->influencer_id);
           if(!$inf) return response()->json([
            'err'=>trans($this->trans_dir.'one_of_the_matches_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));

            $price = $ad->type == 'onsite'?$inf->ad_onsite_price:$inf->ad_price;
            $allInfPrices  = $allInfPrices + $price;
        }
        $chosenInfBudget = $ad->type == 'onsite'?$addInf->ad_onsite_price:$addInf->ad_price;
        $allInfPrices = $allInfPrices + $chosenInfBudget;
        if($allInfPrices > $budget) return response()->json([
            'msg'=>trans($this->trans_dir.'you_have_passed_the_budget'),
            'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        $data->chosen = 1;
        $data->status = 'not_basic';
        $data->save();

        return $this->match_response($ad);

    }

    public function changeMatchStatus(Request $request)
    {

        $ad = Ad::findOrFail($request->ad_id);
        
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $user = Influncer::find($request->influncer_id);
        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();

        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'match_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->status = $request->status;
        $data->save();

       
        return $this->match_response($ad);
    }

    public function wait_for_influencer_response($ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $cal = $data->budget * 5.5/100;

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched'),
            'data'=>[
                'id'=>$data->id,
                'type'=>$data->type,
                'category'=>$data->categories?$data->categories->name:null,
                'price'=>$data->budget - $cal,
                'budget'=>$data->budget,
                'match'=> $data->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item){
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
                      $status = 'pending';
                    }

                    

                    return [
                      'id'=>$item->influencers->id,
                      'image'=>$item->influencers->users->infulncerImage,
                      'name'=>$item->influencers->first_name.' '.$item->influencers->middle_name.' '.$item->influencers->last_name,
                      'match'=>$item->match,
                      'status'=>$status
                    ];
                    })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    public function get_ad_influencers_match($ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $cal = $data->budget * 5.5/100;

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_matched'),
            'data'=>[
                'id'=>$data->id,
                'type'=>$data->type,
                'status'=>$data->status,
                'influncers_status'=>$data->is_all_accepted(),
                'category'=>$data->categories?$data->categories->name:null,
                'price'=>$data->budget - $cal,
                'budget'=>$data->budget,

                'match'=> $data->status == 'prepay'?$this->get_ad_influencers_matchs($data):$this->get_ad_influncers_with_status($data)
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));


    }

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
             * */

            Payment::create([
                'ad_id'=>$ad_id,
                'trans_id'=>$request->TranId,
                'amount'=>$request->amount,
                'status'=>$request->result,
                'status_code'=>$request->ResponseCode,
                'type'=>$request->type,
            ]);
			
             return response()->json([
                'err'=>trans($this->trans_dir.'payment_failed'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
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
                     'msg'=>trans($this->trans_dir.'payment_successfully'),
                     'ad_status'=>$data->status,
                     'status'=>config('global.OK_STATUS'),
                 ],config('global.OK_STATUS'));
			}
		
			return response()->json([
                'err'=>trans($this->trans_dir.'payment_failed'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
    }

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

    public function update(Request $request , $ad_id)
    {
        #GET THE AD AND CHECK IF THE AD EXIST
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        
        if(gettype($request->social_media) == 'array'&&count($request->social_media) > 0)
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
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    private function match_response($ad)
    {
        return response()->json([
            'msg'=>trans($this->trans_dir.'data_was_updated'),
            'status'=>config('global.OK_STATUS'),
			'data'=>[
				'id'=>$ad->id,
				'type'=>$ad->type,
				'status'=>$ad->status,
                'influncers_status'=>$ad->is_all_accepted(),
				'category'=>$ad->categories->name,
				'budget'=>$ad->budget,
				'match'=>$this->get_ad_influencers_matchs($ad)
            ]
            ],config('global.OK_STATUS')
    );
    }

    private function get_ad_influncers_with_status($ad)
    {
        return $ad->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item) use($ad){
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
                    $status = 'pending';
                }

                // $response = [
                //     'id'=>$item->influencers->id,
                //     'image'=>$item->influencers->users->infulncerImage,
                //     'name'=>$item->influencers->first_name.' '.$item->influencers->middle_name.' '.$item->influencers->last_name,
                //     'match'=>$item->match,
                //     'status'=>$status
                // ];

                $inf = $item->influencers;
                $isProfitable =  $ad->campaignGoals->profitable;
                $isOnSite = $ad->ad_type;
         

                $response =  [
                    'id'=>$inf->id,
                    'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
                    'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                    'match'=>$item->match,
                    'gender'=>$item->influencers->gender,
                    'budget'=>$isOnSite?$item->influencers->ad_onsite_price:$item->influencers->ad_price,
                    'status'=>$status
                    
                ];
            // if($eligible != null) $response['eligible'] = $eligible;
    
            $response['ROAS'] = null;
            $response['engagement_rate'] = null;
            $response['aoaf'] = null;
    
            if($isProfitable)
            {
                $response['ROAS'] = $item->match;
            }
            else
            {
                $response['engagement_rate'] = $item->match;
                $response['AOAF'] = $item->AOAF;
            }


                return $response;
            });
    }

    private function get_ad_influencers_matchs($ad)
    {
       $isProfitable =  $ad->campaignGoals->profitable;
       $isOnSite = $ad->ad_type;
        return $ad->matches()->where('status','!=','deleted')->where('chosen',1)->get()->map(function($item) use($isProfitable,$isOnSite){
                
            $response = [
                'id'=>$item->influencers->id,
                'name'=>$item->influencers->first_name.' '.$item->influencers->middle_name.' '.$item->influencers->last_name,
                'image'=>$item->influencers->users->InfulncerImage?$item->influencers->users->InfulncerImage:null,
                'gender'=>$item->influencers->gender,
                'is_primary'=>$item->status == 'basic'?true:false,
                'budget'=>$isOnSite?$item->influencers->ad_onsite_price:$item->influencers->ad_price,
            ];

            $response['ROAS'] = null;
            $response['engagement_rate'] = null;
            $response['aoaf'] = null;
            if($isProfitable)
            {
                $response['ROAS'] = $item->match;
            }
            else
            {
                $response['engagement_rate'] = $item->match;
                $response['AOAF'] = $item->AOAF;
            }

            return $response;
        });
    }

    private function match_influencer_with_eligible_status($inf,$item,$eligible = null,$status)
    {
        $ad = Ad::find($item->ad_id);
        if(!$ad) return response()->json([
            'err'=>trans($this->trans_dir.'ad_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $isProfitable = $ad->campaignGoals->profitable;
       $isOnSite = $ad->ad_type;
        $response =  [
                'id'=>$inf->id,
                'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
                'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                'match'=>$item->match,
                'gender'=>$item->influencers->gender,
                'budget'=>$isOnSite?$item->influencers->ad_onsite_price:$item->influencers->ad_price,
                'status'=>$status
                
            ];
        if($eligible != null) $response['eligible'] = $eligible;

        $response['ROAS'] = null;
        $response['engagement_rate'] = null;
        $response['aoaf'] = null;

        if($isProfitable)
        {
            $response['ROAS'] = $item->match;
        }
        else
        {
            $response['engagement_rate'] = $item->match;
            $response['AOAF'] = $item->AOAF;
        }

        return $response;
    }

    private function onSiteValidation($request)
    {
        if($request->has_marouf_num&&!$request->marouf_num)
        {
            return trans($this->trans_dir.'please_add_a_marouf');
        }
        elseif(!$request->has_marouf_num&&!$request->cr_num)
        {
            return trans($this->trans_dir.'please_add_cr_number');
        }
        elseif(!$request->has_marouf_num&&!$request->cr_image)
        {
            return trans($this->trans_dir.'please_add_cr_image');
        }
        elseif($request->has_online_store&&!$request->store_link)
        {
            return trans($this->trans_dir.'please_add_store_link');
        }
		  elseif($request->has_offer&&!$request->offer > 0)
        {
            return trans($this->trans_dir.'please_add_offer');
        }
		  elseif(!$request->prefered_media_id)
        {
            return trans($this->trans_dir.'please_add_an_prefered_media_id');
        }
		  elseif($request->has_marouf_num == 1&&!$request->marouf_num)
        {
            return trans($this->trans_dir.'please_add_an_marouf_number');
        }
		  elseif($request->has_marouf_num == 0&&!$request->cr_num)
        {
            return trans($this->trans_dir.'please_add_an_cr_number');
        }
		  elseif($request->has_marouf_num == 0&&!$request->cr_image)
        {
            return trans($this->trans_dir.'please_add_an_cr_image');
        }


        return false;
    }

    private function create_contract($ad_id = null , $customer)
    {
        $contractData = Contract::find(1);
        
        if(!$contractData)
        {
            return false;
        }

         $replace = str_replace("[[Name]]",$customer->first_name.' '.$customer->last_name,$contractData->content);


        if($contractData)
        {
            return Contract::create([
                'title'=>$contractData->title,
                'content'=>$replace,
                'ad_id'=>$ad_id,
            ]);
        }
        else
        {
            return false;
        }
      
    }
    private function create_customer_contract($ad_id = null , $customer)
    {
        $contractData = AppSetting::where('key','Customer Contract')->first();
       

        if(!$contractData) return false;
        
         $replace = str_replace("[[Name]]",$customer->first_name.' '.$customer->last_name,json_decode($contractData->value));

        
        if($contractData)
        {
            return CampaignContract::create([
                'content'=>$replace,
                'ad_id'=>$ad_id,
                'is_accepted'=>0
            ]);
        }
        else
        {
            return false;
        }
      
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

    function deleteGalleryMedia($id){
        $media = DB::table('media')->where('id',$id)->where('model_type','App\Models\Influncer')->first();
        if(!$media)return response()->json([
            'err'=>trans($this->trans_dir.'file_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $model_type = $media->model_type;
        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);

        return response()->json([
            'msg'       => trans($this->trans_dir.'media_deleted_successfully'),
            'status'    => true,
        ],200);
    }

    
}
