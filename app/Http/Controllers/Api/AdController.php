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
use App\Models\Contract;
use Validator;

class AdController extends Controller
{
    protected $guard = 'api';

    public function store(AdRequest $request)
    {
        #CHECK IF THERE IS A CONTRACT IN THE DATABASE
        if(!$this->create_contract()) return response()->json([
            'err'=>'There is no contract in the system',
            'status'=>200
        ],200);

        #CHECK REQUEST 
        if(!$request->hasFile('documnet')&&!$request->auth_number)
        {
           
            return response()->json([
                'err'=>'please upload a document or add the authentication number',
                'status'=>403
            ],200);
        }
        $data = array_merge($request->all(),['customer_id'=>Auth::guard('api')->user()->customers->id]);

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
        if($request->hasFile('documnet'))
        {
            $data->addMedia($request->file('document'))
            ->toMediaCollection('document');
        }
        $users = [User::find(1)];
        $info =[
            'msg'=>'Customer "'.Auth::guard('api')->user()->customers->first_name.'" added new ad'
        ];
        Notification::send($users, new AddInfluencer($info));

        return response()->json([
            'msg'=>'ad was created',
            'status'=>201
        ],201);
    }

    public function details($id)
    {
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'err'=>'ad not found',
            'status'=>404
        ],200);

        $influncers_info = null;
        if($data->influncers) 
        {
            $influncers_info = [
                'name_en'=>$data->influncers->full_name_en,
                'name_ar'=>$data->influncers->full_name_ar,
                'image'=>$data->influncers->users->image
            ];
        }

        return response()->json([
            'store_name'=>$data->store,
            'image'=>$data->image,
            'budget'=>$data->budget,
            'about'=>$data->about,
            'location'=>$data->countries()->select(['name','code'])->get(),
            'auth_number'=>$data->auth_number,
            'category'=>$data->categories->name,
            'date'=>$data->date,
            'videos'=>$data->videos,
            'social_media'=>[
                'name'=>$data->socialMedias->name,
                'logo'=>$data->socialMedias->image
            ],
            'influencer'=>$influncers_info,
            'script'=>$data->ad_script,
            'contract_id'=>$data->contacts->id
        ]);
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
            'status'=>404
        ],404);
        return response()->json([
            'msg'=>'ad contract',
            'data'=>$data,
            'status'=>200
        ],200);
    }

    public function accept_ad_contract($contract_id,$influencer_id)
    {
        $data = Contract::find($contract_id);
        if(!$data) return response()->json([
            'err'=>'contract not found',
            'status'=>404
        ],404);
        $inf_data = User::find($influencer_id);
        if(!$inf_data || !$inf_data->influncers) return response()->json([
            'err'=>"influencer not found, please make sure the id you'r adding is belongs to influencer",
            'status'=>404
        ],404);
        $data->ads()->associate($inf_data);
        $data->is_accepted = true;
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
            'status'=>204
        ],200);
    }

    public function search($query)
    {
        $data = Ad::where('store','LIKE',"%{$query}%")->paginate(10);
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
            'status'=>200
        ]);
    }


   
}
