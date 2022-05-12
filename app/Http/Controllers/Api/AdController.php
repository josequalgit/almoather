<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Requests\Api\AdRequest;
use App\Http\Requests\Api\AcceptAdContractRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Models\User;
use App\Models\Influncer;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\StoreLocation;
use App\Models\AdsInfluencerMatch;
use App\Http\Traits\UserResponse;
use App\Http\Traits\ApiPaginator;
use App\Http\Traits\AdResponse;
use Auth;
use Validator;

use DB;

class AdController extends Controller
{
    protected $guard = 'api';

    use ApiPaginator , UserResponse , AdResponse;

    public function index($status)
    {

        $user_id = Auth::guard('api')->user()->influncers ? Auth::guard('api')->user()->influncers->id :Auth::guard('api')->user()->customers->id;

        if(Auth::guard('api')->user()->influncers)
        {
            if(!in_array($status,config('global.INFLUENCER_ADS_STATUS'))){
                return response()->json([
                    'err'=>'influencer is not authorized to get ads with this status',
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
                ->where('influencer_status',1)
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            elseif($status == 'Active')
            {
                $itemsPaginated =  $data
                ->where('influencer_status',0)
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            elseif($status == 'Pending')
            {
                $itemsPaginated =  $data
                ->where('influencer_status',0)
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            elseif($status == 'Rejected')
            {
                $itemsPaginated =  $data
                ->where('influencer_status',0)
                ->where('is_accepted',$statusCode[$status])
                ->paginate(10);
            }
            else
            {
                $itemsPaginated = $data->paginate(10);
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
                'msg'=>'get all ads with the status',
                'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));


        }
        else
        {
            if(!in_array($status,config('global.CUSTOMER_ADS_STATUS'))) return response()->json([
                'err'=>'customer is not authorized to get ads with this status',
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

            $statusCode = [
                'WaitingPayment'    => ['approve','prepay'],
                'Active'            => ['fullpayment','active','progress'],
                'Finished'          => ['complete']
            ];

            if(in_array($status,array_keys($statusCode)))
            {
                $itemsPaginated = Ad::where('customer_id',$user_id)->whereIn('status',$statusCode[$status])->paginate(10);
            }
            else
            {
                $itemsPaginated = Ad::where([['customer_id',$user_id],['status',$status]])->paginate(10);
            }

            $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                return $this->adResponse($item);
            })->toArray();
        }

        return response()->json([
            'msg'=>'get all ads with the status',
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
                'err'=>'please upload a document or add the authentication number',
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
            'err'=>'There is no contract in the system',
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
        $info =[
            'msg'=>'Customer "'.Auth::guard('api')->user()->customers->first_name.'" added new ad'
        ];
        Notification::send($users, new AddInfluencer($info));

        return response()->json([
            'msg'=>'ad was created',
            'data'=>$this->adResponse($data),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function details($id)
    {
        $data = Ad::find($id);
        //return $data->videos;
        if(!$data) return response()->json([
            'err'=>'ad not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'=>'ad details',
            'data'=>$this->adResponse($data),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
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
        $contractData = Contract::find(2);
        
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
                'customer_id'=>$customer->id
            ]);
        }
        else
        {
            return false;
        }
      
    }

    public function get_ad_contract($ad_id)
    {
        $ad = Ad::find($ad_id);
        if(!$ad) return response()->json([
            'err'=>'ad was not',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(!$ad||$ad->status == 'pending'||$ad->status == 'rejected') return response()->json([
            'err'=>'there is no contract for the ad because ad status is '.$ad->status,
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        $data = Contract::select(['title','content'])->find($ad->contacts->id);
        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'ad contract',
            'data'=>$data->content,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function accept_ad_contract(AcceptAdContractRequest $request,$contract_id)
    {

        $data = Contract::find($contract_id);

        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->is_accepted = $request->status;
        $data->rejectNote = $request->reject_note;
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function search($query)
    {

        $user_id = Auth::guard('api')->user()->influncers ? Auth::guard('api')->user()->influncers->id :Auth::guard('api')->user()->customers->id;

        if(Auth::guard('api')->user()->influncers)
        {
            $data = Auth::guard('api')->user()->influncers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
            // $data = Auth::guard('api')->user()->influncers
            // ->join('ad', 'ad.ad_id', '=', 'influncer.influencer_id')
            // ->whereHas('ad_matches',function($q) use($query){
            //     $q->ads()->where([['store','LIKE',"%{$query}%"]]);
            // })->get();
            // dd($data);

        }
        else
        {
            $data = Auth::guard('api')->user()->customers->ads()->where([['store','LIKE',"%{$query}%"]])->paginate(10);
        }

        $data->getCollection()->transform(function($item){
             return $this->adResponse($item);
        });


        return response()->json([
            'msg'=>'the search result',
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ]);
    }


    public function get_influencer_ads($influencer_id,$status = null)
    {
        $data = Influncer::find($influencer_id);
        $itemsPaginated  = [];
        if(!$data) return response()->json([
            'err'=>'influencer not found',
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
            'msg'=>'all influencer ads',
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }


    public function get_customers_ads($customer_id , $status = null)
    {
        $data = Customer::find($customer_id);
        $itemsPaginated  = [];
        if(!$data) return response()->json([
            'err'=>'customer not found',
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
            'msg'=>'all customer ads',
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    private function onSiteValidation($request)
    {
        if($request->has_marouf_num&&!$request->marouf_num)
        {
            return 'Please add a marouf  number';
        }
        elseif(!$request->has_marouf_num&&!$request->cr_num)
        {
            return 'Please add a cr number';
        }
        elseif(!$request->has_marouf_num&&!$request->cr_image)
        {
            return 'Please add a cr image';
        }
        elseif($request->has_online_store&&!$request->store_link)
        {
            return 'Please add a store link';
        }
		  elseif($request->has_offer&&!$request->offer > 0)
        {
            return 'Please add an offer';
        }
		  elseif(!$request->prefered_media_id)
        {
            return 'Please add an prefered media id';
        }
		  elseif($request->has_marouf_num == 1&&!$request->marouf_num)
        {
            return 'Please add marouf number';
        }
		  elseif($request->has_marouf_num == 0&&!$request->cr_num)
        {
            return 'Please add cr number';
        }
		  elseif($request->has_marouf_num == 0&&!$request->cr_image)
        {
            return 'Please add cr image';
        }


        return false;
    }

    public function getMatchedInfluencers($id)
    {
        $data = Ad::findOrFail($id);
        if($data->status !== 'prepay') return response()->json([
            'err'=>'ad dosent have the right status',
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
            'msg'=>'all matched under budget influencer',
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function getMatchedInfluencersNotChosen($id,$removed_inf_id,$replace_permission = null)
    {
        $data = Ad::find($id);
        $info = Influncer::find($removed_inf_id);

        if(!$data) return response()->json([
            'err'=>'ad not found',
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
                
              //  dd($item);
                
    
                if($data->onSite)
                {
                    $currentBudget = ($currentInf->ad_onsite_price >= $item->influencers->ad_onsite_price)?1:0;
                    
                }
                else
                {
    
                    $currentBudget = ($currentInf->ad_price >= $item->influencers->ad_price)?1:0;
                }
                $counter = $counter +1;
                
    
                return $this->matchResponse($item->influencers,$item->match,$counter == 2?:$currentBudget,$item->status);
                
            });



            return response()->json([
                'msg'=>'all matched under budget influencer',
                'data'=>$infData,
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }

        if(!$info) return response()->json([
            'err'=>'user not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
      
        if(!$replace_permission&&$data->status !== 'prepay') return response()->json([
            'err'=>'ad dosent have the right status',
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
			

            return $this->matchResponse($item->influencers,$item->match,$counter == 2?:$currentBudget,$item->status);
            
        });

        return response()->json([
            'msg'=>'all matched under budget influencer',
            'data'=>$infData,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function replace_matched_influencer($id , $removed_influencer , $chosen_influencer)
    {
        $removeFromChosen = AdsInfluencerMatch::where([['ad_id',$id],['influencer_id',$removed_influencer]])->first();

        dd($removeFromChosen);
		
        if(!$removeFromChosen) return response()->json([
            'err'=>'data not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
		
        $removeFromChosen->chosen = 0;
        $removeFromChosen->save();

        $addToChosen = AdsInfluencerMatch::where([['ad_id',$id],['influencer_id',$chosen_influencer]])->first();
        if(!$addToChosen) return response()->json([
            'err'=>'data not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $addToChosen->chosen = 1;
        $addToChosen->status = 'not_basic';
        $addToChosen->save();
        $data = Ad::findOrFail($id);

        return response()->json([
            'msg'=>'data was updated',
			'data'=>[
                'id'=>$data->id,
				'type'=>$data->type,
				'category'=>$data->categories->name,
				'budget'=>$data->budget,
				'match'=> $data->matches()->where('chosen',1)->where('status','!=','deleted')->get()->map(function($item){
					$inf = $item->influencers;
					return [
						'id'=>$inf->id,
						'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                        'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
						'match'=>$item->match,
						'status'=>$item->status,
					];
				})
			],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));


    }

    public function before_payment($id)
    {
        $data = Ad::find($id);
        
        if(!$data) return response()->json([
            'err'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $cal = $data->budget*5.5/100;

        if($data->status !== 'approve') return response()->json([
            'err'=>'ad dosent have the right status',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

       // dd(Auth::user()->customers);
        $name = Auth::guard('api')->user()->customers->first_name.' '.Auth::guard('api')->user()->customers->middle_name.' '.Auth::guard('api')->user()->customers->last_name;
        $info =[
            'msg'=>'Customer "'.$name.'" payed 5% ('.$cal.') for "'.$data->store.'" ',
        ];
      
        $users = [
            1,
            2
        ];
        foreach ($users as $value) {
            Notification::send(User::find($value), new AddInfluencer($info));
        }
        

        return response()->json([
            'msg'=>'all matches blurred',
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

    public function pay_now($id)
    {
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'err'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if($data->status !== 'approve'&&$data->status !=='prepay') return response()->json([
            'err'=>'ad dosent have the right status',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        
        $cal = $data->budget*5.5/100;

        if($data->status == 'approve')
        {
            $data->status = 'prepay';
            $data->save();
        }

        
      

        return response()->json([
            'msg'=>'all matches',
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
            'err'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(!$user||!$user->influncers) return response()->json([
            'err'=>'influencer was not found',
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
            'msg'=>'unchosen match',
            'data'=>$alldata,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }
   

    private function matchResponse($inf,$match,$eligible = null,$status)
    {
        $response =  [
                'id'=>$inf->id,
                'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
                'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                'match'=>$match,
                'status'=>$status
                
            ];
        if($eligible != null) $response['eligible'] = $eligible;
        return $response;
    }

    public function full_payment($ad_id)
    {
        $ad = Ad::find($ad_id);
        if(!$ad) return response()->json([
            'err'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        
        if($ad->status !== 'prepay') return response()->json([
            'err'=>'ad dosent have the right status',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $ad->status = 'fullpayment';
        $ad->save();

        $name = Auth::guard('api')->user()->customers->first_name.' '.Auth::guard('api')->user()->customers->middle_name.' '.Auth::guard('api')->user()->customers->last_name;
        $info =[
            'msg'=>'Customer "'.$name.'" payed full payment ('.$ad->budget.') for "'.$data->store.'" ',
        ];
      
        $users = [
            1,
            2
        ];
        foreach ($users as $value) {
            Notification::send(User::find($value), new AddInfluencer($info));
        }

        return response()->json([
            'msg'=>'ad status was changed to '.$ad->status.'',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    public function completeAd($contract_id)
    {
        $data = Contract::find($contract_id)->first();

        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->influencer_status = 1;
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function accept_customer_ad_contract(Request $request , $contract_id)
    {
        $data = Contract::find($contract_id);
        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->is_accepted = $request->status;
        $data->rejectNote = $request->rejectNote;
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }

    public function addMatch(Request $request)
    {
        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();
        $addInf = Influncer::find($request->influncer_id);
        if(!$data) return response()->json([
            'err'=>'influencer match was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $ad = Ad::find($request->ad_id);
        if(!$ad) return response()->json([
            'err'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $budget = $ad->budget;
        $matches = $ad->matches;
        $allInfPrices = 0;

        foreach ($matches as $value) {
           $inf = Influncer::find($value->influencer_id);
           if(!$inf) return response()->json([
            'err'=>'one of the matches was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));

            $price = $ad->type == 'onsite'?$inf->ad_onsite_price:$inf->ad_price;
            $allInfPrices  = $allInfPrices + $price;
        }
        $chosenInfBudget = $ad->type == 'onsite'?$addInf->ad_onsite_price:$addInf->ad_price;
        $allInfPrices = $allInfPrices + $chosenInfBudget;
        if($allInfPrices > $budget) return response()->json([
            'msg'=>'you have passed the budget',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        $data->chosen = 1;
        $data->status = 'not_basic';
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
			'data'=>[
				'id'=>$ad->id,
				'type'=>$ad->type,
				'category'=>$ad->categories->name,
				'budget'=>$ad->budget,
				'match'=> $ad->matches()->where('chosen',1)->where('status','!=','deleted')->get()->map(function($item){
					$inf = $item->influencers;
					return [
						'id'=>$inf->id,
						'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                        'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
						'match'=>$item->match,
						'status'=>$item->status,
					];
				})
			],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));



        // return response()->json([
        //     'msg'=>'influencer was added',
        //     'status'=>config('global.OK_STATUS')
        // ],config('global.OK_STATUS'));
    }

    public function changeMatchStatus(Request $request)
    {
        $user = Influncer::find($request->influncer_id);
        $data = AdsInfluencerMatch::where([['ad_id',$request->ad_id],['influencer_id',$request->influncer_id]])->first();
        if(!$data) return response()->json([
            'err'=>'influencer match was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $data->status = $request->status;
        $data->save();


        $ad = Ad::findOrFail($request->ad_id);

        return response()->json([
            'msg'=>'data was updated',
			'data'=>[
				'id'=>$ad->id,
				'type'=>$ad->type,
				'category'=>$ad->categories->name,
				'budget'=>$ad->budget,
				'match'=> $ad->matches()->where('chosen',1)->where('status','!=','deleted')->get()->map(function($item){
					$inf = $item->influencers;
					return [
						'id'=>$inf->id,
						'image'=>$inf->users->InfulncerImage?$inf->users->InfulncerImage:null,
                        'name'=>$inf->first_name.' '.$inf->middle_name.' '.$inf->last_name,
						'match'=>$item->match,
						'status'=>$item->status,
					];
				})
			],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));









        // return response()->json([
        //     'msg'=>'match status was change',
        //     'status'=>config('global.OK_STATUS')
        // ],config('global.OK_STATUS'));
    }

    


    

}
