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
            $data = Ad::where([['influncer_id',$user_id],['status',$status]])->paginate(10);
        }
        else
        {
            $data = Ad::where([['customer_id',$user_id],['status',$status]])->paginate(10);
        }

        $data->getCollection()->transform(function($item){
            return $this->adResponse($item);
        });


        return response()->json([
            'msg'=>'get all ads with the status',
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function store(AdRequest $request)
    {
        #CHECK IF THERE IS A CONTRACT IN THE DATABASE
        if(!$this->create_contract()) return response()->json([
            'err'=>'There is no contract in the system',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

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

    private function create_contract($ad_id = null)
    {
        $contractData = Contract::find(1);
        if(!$contractData)
        {
            return false;
        }

      
        if($contractData)
        {
            return Contract::create([
                'title'=>$contractData->title,
                'content'=>$contractData->content,
                'ad_id'=>$ad_id
            ]);
        }
        else
        {
            return false;
        }
      
    }

    public function get_ad_contract($contract_id)
    {
        $data = Contract::select(['title','content'])->find($contract_id);
        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'ad contract',
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function accept_ad_contract($contract_id,$influencer_id)
    {
        $data = Contract::find($contract_id);

        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $inf_data = User::find($influencer_id);
        if(!$inf_data || !$inf_data->influncers) return response()->json([
            'err'=>"influencer not found, please make sure the id you'r adding is belongs to influencer",
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        
        $data->ads()->associate($inf_data);
        $data->is_accepted = true;
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
        $data = Ad::findOrFail($id);
        $info = User::find($removed_inf_id);
        if(!$data) return response()->json([
            'err'=>'ad not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        if(!$info) return response()->json([
            'err'=>'user not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        if(!$info->influncers) return response()->json([
            'err'=>'user is not a influencer',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $infData = $data->matches()->where('chosen',0)->get()->map(function($item) use($data , $info){
            $currentInf = $item->influencers;

            $eligible = 0;
            $currentBudget = 0;
            if($data->onSite)
            {
                $currentBudget = ($currentInf->ad_onsite_price <= $info->influncers->ad_onsite_price)?1:0;
            }
            else
            {
                $currentBudget = ($currentInf->ad_price <= $info->influncers->ad_price)?1:0;
            }
            return [
                'name'=>$currentInf->full_name,
                'match'=>$item->match,
                'eligible'=>$currentBudget
            ];
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
        
        $removeFromChosen->chosen = 0;
        $removeFromChosen->save();

        $addToChosen = AdsInfluencerMatch::where([['ad_id',$id],['influencer_id',$chosen_influencer]])->first();
        $addToChosen->chosen = 0;
        $addToChosen->save();

        return response()->json([
            'msg'=>'data was updated',
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


        return response()->json([
            'msg'=>'all matches blurred',
            'data'=>[
                'type'=>$data->type,
                'category'=>$data->categories->name,
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
        $data->status = 'fullpayment';
        $data->save();

        $cal = $data->budget*5.5%100;

        return response()->json([
            'msg'=>'all matches',
            'data'=>[
                'type'=>$data->type,
                'category'=>$data->categories->name,
                'budget'=>$data->budget,
                'matches'=>$data->matches()->get()->map(function($item){
                    return [
                        'name'=>$item->influencers->full_name,
                        'rate'=>$item->match
                    ];
                })
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
   
}
