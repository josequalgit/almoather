<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Requests\Api\AdRequest;
use Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Models\User;
use App\Models\Influncer;
use App\Models\Customer;
use App\Models\Contract;
use App\Models\AdsInfluencerMatch;
use Validator;
use App\Http\Traits\UserResponse;
use App\Http\Traits\ApiPaginator;
use App\Http\Traits\AdResponse;

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
            if(!in_array($status,config('global.INFLUENCER_ADS_STATUS'))) return response()->json([
                'err'=>'influencer is not authorized to get ads with this status',
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));


            $data = Ad::where([['influncer_id',$user_id],['status',$status]])->get();

            if($status == 'Pending')
            {
               
               
                $itemsPaginated = Auth::guard('api')->user()->influncers->contracts()->where('is_accepted',2)->paginate(10);

                $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                    return $this->adResponse($item->ads);
                })->toArray();
                



                return response()->json([
                    'msg'=>'get all ads with the status',
                    'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                    'status'=>config('global.OK_STATUS')
                ],config('global.OK_STATUS'));

               

            }
            elseif($status == 'Active')
            {
              
                $itemsPaginated = Auth::guard('api')->user()->influncers->contracts()->where('is_accepted',1)->paginate(10);

                $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                    return $this->adResponse($item->ads);
                })->toArray();
                
                
                return response()->json([
                    'msg'=>'get all ads with the status',
                    'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                    'status'=>config('global.OK_STATUS')
                ],config('global.OK_STATUS'));

            }
            elseif($status == 'Completed')
            {
                $itemsPaginated = Auth::guard('api')->user()->influncers->contracts()->where('is_accepted',0)->paginate(10);

                $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                    return $this->adResponse($item->ads);
                })->toArray();
                

                
                return response()->json([
                    'msg'=>'get all ads with the status',
                    'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                    'status'=>config('global.OK_STATUS')
                ],config('global.OK_STATUS'));
            }
            elseif($status == 'Rejected')
            {
                $itemsPaginated = Auth::guard('api')->user()->influncers->contracts()->where('is_accepted',0)->paginate(10);

                $itemsTransformed = $itemsPaginated->getCollection()->transform(function($item) use($user_id){
                    return $this->adResponse($item->ads);
                })->toArray();

                
                return response()->json([
                    'msg'=>'get all ads with the status',
                    'data'=>$this->formate($itemsTransformed , $itemsPaginated),
                    'status'=>config('global.OK_STATUS')
                ],config('global.OK_STATUS'));
            }


        }
        else
        {
            if(!in_array($status,config('global.CUSTOMER_ADS_STATUS'))) return response()->json([
                'err'=>'customer is not authorized to get ads with this status',
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

            if($status == 'WaitingPayment')
            {
               
                $itemsPaginated = Ad::where([['customer_id',$user_id],['status','prepay']])
                ->orWhere([['customer_id',$user_id],['status','approve']])
                ->paginate(10);
            }
            elseif($status == 'Active')
            {
                $itemsPaginated = Ad::where([['customer_id',$user_id],['status','progress']])
                ->orWhere([['customer_id',$user_id],['status','active']])
                ->orWhere([['customer_id',$user_id],['status','fullpayment']])
                ->paginate(10);
            }
            elseif($status == 'Finished')
            {
                $itemsPaginated = Ad::where([['customer_id',$user_id],['status','complete']])
                ->paginate(10);
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
        if(!$request->hasFile('cr_image')&&!$request->has_marouf_num)
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

         #CHECK IF THERE IS A CONTRACT IN THE DATABASE
         if(!$this->create_contract($data->id,Auth::guard('api')->user()->customers)) return response()->json([
            'err'=>'There is no contract in the system',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        if(count($request->prefered_media_id) > 0)
        {
            foreach ($request->prefered_media_id as $value) {

              //  DB::table('ads_media_id')->insert([
                //    'ad_id'=>$data->id,
              //      'social_media_id'=>$value['type']??$value->type,
              //      'link'=>$value['link']??$value->type
             //   ]);
				$data->socialMediasAccount()->attach($value);
				$data->save();

				
            }
        }
		 if(count($request->social_media) > 0)
        {
            foreach ($request->social_media as $value) {

                DB::table('social_media_id')->insert([
                    'ad_id'=>$data->id,
                   'social_media_id'=>$value['type']??$value->type,
                   'link'=>$value['link']??$value->type
                ]);
				//$data->socialMedias()->attach($value);
			//	$data->save();
            }
        }
        if($request->video&&count($request->video) > 0)
        {
            foreach ($request->video as $value) {
                $data->addMedia($value)
                ->toMediaCollection('adVideos');
            }
        }

        if($request->video&&count($request->image) > 0)
        {
            foreach ($request->image as $value) {
                $data->addMedia($value)
            ->toMediaCollection('adImage');
            }
        }
        if($request->hasFile('cr_image'))
        {
            $data->addMedia($request->file('cr_image'))
            ->toMediaCollection('document');
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
                'ad_id'=>$ad_id
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

    public function accept_ad_contract($contract_id,$status)
    {

        $data = Contract::find($contract_id);

        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->is_accepted = $status;
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
            $data = Ad::where([['influncer_id',$user_id],['store','LIKE',"%{$query}%"]])->paginate(10);
        }
        else
        {
            $data = Ad::where([['customer_id',$user_id],['store','LIKE',"%{$query}%"]])->paginate(10);
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

    public function getMatchedInfluencersNotChosen($id,$removed_inf_id)
    {
        $data = Ad::find($id);
        $info = Influncer::find($removed_inf_id);

        if(!$data) return response()->json([
            'err'=>'ad not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        if(!$info) return response()->json([
            'err'=>'user not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
      
        if($data->status !== 'prepay') return response()->json([
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
			

            return $this->matchResponse($item->influencers,$item->match,$counter == 2?:$currentBudget);
            
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
        $addToChosen->save();
        $data = Ad::findOrFail($id);

        return response()->json([
            'msg'=>'data was updated',
			'data'=>[
				'type'=>$data->type,
				'category'=>$data->categories->name,
				'budget'=>$data->budget,
				'match'=> $data->matches()->where('chosen',1)->get()->map(function($item){
					$inf = $item->influencers;
					return [
						'id'=>$inf->id,
						'image'=>$inf->users->infulncerImage??'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dmlld3xlbnwwfHwwfHw%3D&w=1000&q=80',
						'name'=>$inf->full_name,
						'match'=>$item->match
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


        return response()->json([
            'msg'=>'all matches blurred',
            'data'=>[
                'type'=>$data->type,
                'category'=>$data->categories ? $data->categories->name : null,
                'price'=>$cal,
                'budget'=>$data->budget,
                'matches'=>$data->matches()->get()->map(function($item){
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
                'match'=> $data->matches()->where('chosen',1)->get()->map(function($item){
                        return [
							'id'=>$item->influencers->id,
                            'name'=>$item->influencers->full_name,
                            'image'=>$item->infulncerImage ?? 'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dmlld3xlbnwwfHwwfHw%3D&w=1000&q=80',
                            'match'=>$item->match
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

        $alldata = $data->matches()->where('chosen',0)->get()->map(function($item) use($inf,$data,$removed_inf){
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
   

    private function matchResponse($inf,$match,$eligible)
    {
        return [
			'id'=>$inf->id,
            'name'=>$inf->full_name,
            'image'=>$inf->users->infulncerImage ?? 'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dmlld3xlbnwwfHwwfHw%3D&w=1000&q=80',
            'match'=>$match,
            'eligible'=>$eligible
        ];
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

        return response()->json([
            'msg'=>'ad status was changed to '.$ad->status.'',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }


    

}
