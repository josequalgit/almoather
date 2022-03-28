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


class AdController extends Controller
{
    protected $guard = 'api';

    use ApiPaginator , UserResponse , AdResponse;

    public function index($status)
    {
        $data = Ad::where('status',$status)->paginate(10);
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
        if(!$request->hasFile('documnet')&&!$request->auth_number)
        {
            return response()->json([
                'err'=>'please upload a document or add the authentication number',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        $data = array_merge($request->all(),['customer_id'=>Auth::guard('api')->user()->customers->id]);

        if($request->onSite)
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
       
        if($request->hasFile('video'))
        {
            $data->addMedia($request->file('video'))
            ->toMediaCollection('adVideos');
        }
        if($request->hasFile('image'))
        {
            $data->addMedia($request->file('image'))
            ->toMediaCollection('adImage');
        }
        if($request->hasFile('document'))
        {
            $data->addMedia($request->file('document'))
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
            'data'=>[
                'id'=>$data->id
            ],
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
        $data = Ad::where('store','LIKE',"%{$query}%")->paginate(config('global.PAGINATION_NUMBER'));
        $data->getCollection()->transform(function($item){
            $influncers_info = null;
            if($item->influncers) 
            {
                $influncers_info = [
                    'name_en'=>$item->influncers->full_name_en,
                    'name_ar'=>$item->influncers->full_name_ar,
                    'image'=>$item->influncers->users->image
                ];
            }
            return [
                'id'=>$item->id,
                'store_name'=>$item->store,
                'image'=>$item->image,
                'budget'=>$item->budget,
                'about'=>$item->about,
                'location'=>$item->countries()->select(['name','code'])->get(),
                'auth_number'=>$item->auth_number,
                'category'=>$item->categories->name,
                'date'=>$item->date,
                'videos'=>$item->videos,
                'social_media'=>[
                    'name'=>$item->socialMedias->name,
                    'logo'=>$item->socialMedias->image
                ],
                'influencer'=>$influncers_info,
                'script'=>$item->ad_script,
                'contract_id'=>$item->contacts->id
            ];
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
            $customer_info = null;
            if($item->customers) 
            {
                $customer_info = [
                    'first_name'=>$item->customers->first_name,
                    'last_name'=>$item->customers->last_name,
                    'phone'=>$item->customers->phone,
                    'country'=>$item->customers->countrys->name,
                    'cities'=>$item->customers->citys->name,
                    'nationality'=>$item->customers->nationalities->name,
                    'status'=>$item->customers->status,
                    'image'=>$item->customers->users->image
                ];
            }

          

            return [
                'id'=>$item->id,
                'store_name'=>$item->store,
                'image'=>$item->image,
                'budget'=>$item->budget,
                'about'=>$item->about,
                'city'=>$item->cities()->select(['id','name'])->first(),
                'country'=>$item->countries()->select(['id','name'])->first(),
                'auth_number'=>$item->auth_number,
                'category'=>$item->categories->name,
                'date'=>$item->date,
                 'videos'=>$item->videos,
                'social_media'=>[
                    'name'=>$item->socialMedias->name,
                    'logo'=>$item->socialMedias->image
                ],
                'customer'=>$customer_info,
                'script'=>$item->ad_script,
                'service_type'=>$item->type,
                'type'=>$item->onSite ? 'Online Advertisement' :'Site Advertisement',
            ];

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
            $customer_info = null;
            if($item->customers) 
            {
                $customer_info = [
                    'name_en'=>$item->customers->full_name_en,
                    'name_ar'=>$item->customers->full_name_ar,
                    'image'=>$item->customers->users->image
                ];
            }

          

            return [
                'id'=>$item->id,
                'store_name'=>$item->store,
                'image'=>$item->image,
                'budget'=>$item->budget,
                'about'=>$item->about,
                'city'=>$item->cities()->select(['id','name'])->first(),
                'country'=>$item->countries()->select(['id','name'])->first(),
                'auth_number'=>$item->auth_number,
                'category'=>$item->categories->name,
                'date'=>$item->date,
                 'videos'=>$item->videos,
                'social_media'=>[
                    'name'=>$item->socialMedias->name,
                    'logo'=>$item->socialMedias->image
                ],
                'customer'=>$customer_info,
                'script'=>$item->ad_script,
                'service_type'=>$item->type,
                'type'=>$item->onSite ? 'Online Advertisement' :'Site Advertisement',
            ];

        })->toArray();


        return response()->json([
            'msg'=>'all customer ads',
            'data'=>$this->formate($itemsTransformed , $itemsPaginated),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    private function onSiteValidation($request)
    {
        if(!$request->delivery_man_name)
        {
            return 'Please add a delivery man name';
        }
        elseif(!$request->delivery_phone_number)
        {
            return 'Please add a delivery phone number';
        }
        elseif(!$request->delivery_city_name)
        {
            return 'Please add a city name';
        }
        elseif(!$request->delivery_area_name)
        {
            return 'Please add a area name';
        }
        elseif(!$request->delivery_street_name)
        {
            return 'Please add a street name';
        }
        elseif(!$request->nearest_location)
        {
            return 'Please add a nearest location';
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


   
}
