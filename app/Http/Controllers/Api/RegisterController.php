<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\InfluncerRequest;
use App\Http\Requests\Api\CustomerRequest;
use App\Models\User;
use App\Models\Influncer;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Category;
use App\Models\InfluncerCategory;
use App\Models\SocialMediaProfile;
use App\Models\City;
use App\Notifications\AddInfluencer;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function registerInfluncer(InfluncerRequest $request)
    {
        $info =[
            'msg'=>$request->message,
        ];
        if($this->checkIfDataAvalibale($request))
        {
            return response()->json([
                'msg'=>$this->checkIfDataAvalibale($request),
                'status'=>200
            ]);
        }

        $commingRequest =  array_merge($request->only(['email','password','name']),['password'=>bcrypt($request->password)]);
        $data = User::create($commingRequest);
        $data->addMedia($request->file('image'))
        ->toMediaCollection('influncers');
        $influncerData = $request->only([
            'full_name_en',
            'full_name_ar',
            'nick_name',
            'bank_name',
            'bank_account_number',
            'bio',
            'ads_out_country',
            'city_id',
            'country_id',
            'nationality_id',
            'region_id',
            'user_id',
            'is_vat',
            'ad_price',
            'ad_onsite_price',
            'id_number',
            'phone',
            'ad_with_vat',
            'ad_onsite_price_with_vat',
            'birthday',
            'address_id',
            'bank_id'
        ]);

       $addUserId =  array_merge($influncerData,['user_id'=>$data->id]);
       $newInfluncer = Influncer::create($addUserId);

       foreach($request->categories as $item)
       {
           $newInfluncer->InfluncerCategories()->attach($item);
       }

       foreach ($request->social_media as $item) {
            $obj = $item;
           if(!is_object($item)) $obj = (object)$item;
            SocialMediaProfile::create([
                'link'=>$obj->link,
                'social_media_id'=>$obj->type,
                'Influncer_id'=>$newInfluncer->id
            ]);
       }

        $users = [User::find(1)];
        $info =[
            'msg'=>'New Influncer "'.$newInfluncer->full_name_en.'" registered'
        ];
        Notification::send($users, new AddInfluencer($info));

        return response()->json([
            'msg'=>'Influncer was created',
            'status'=>201
        ],201);
    }

    public function registerCustomer(CustomerRequest $request)
    {
        if($this->checkIfDataAvalibale($request))
        {
            return response()->json([
                'msg'=>$this->checkIfDataAvalibale($request),
                'status'=>200
            ]);
        }
        $info =[
            'msg'=>$request->message,
        ];
        $commingRequest =  array_merge($request->only(['email','password','name']),['password'=>bcrypt($request->password)]);
        $data = User::create($commingRequest);
        $data->addMedia($request->file('image'))
        ->toMediaCollection('customers');

        $customerData = $request->only([
            'first_name',
            'last_name',
            'phone',
            'country_id',
            'nationality_id',
            'region_id',
            'user_id',
            'city_id'
        ]);
        $addUserId =  array_merge($customerData,['user_id'=>$data->id]);
        $newCustomer = Customer::create($addUserId);
       

        $users = [User::find(1)];
        $info =[
            'msg'=>'New Customer "'.$newCustomer->first_name.'" registered'
        ];
        Notification::send($users, new AddInfluencer($info));
        return response()->json([
            'msg'=>'Customer was created',
            'status'=>201
        ],201);
    }

    public function verify($user_id)
    {
        $data = User::find($user_id);
        
        # IF THE USER IS NOT FOUND 
        if(!$data) return response()->json([
            'err'=>'user not found',
            'status'=>404
        ],404);

        #IF THE USER ALREADY VERIFIED
        if($data->email_verified_at) return response()->json([
            'err'=>'user already verified',
            'status'=>200
        ],200);

        #UPDATE THE USER
        $data->email_verified_at = Carbon::parse()->now();
        $data->save();

        #RETURN WITH 204 STATUS CODE
        return response()->json([
            'msg'=>'user is verified',
            'status'=>204
        ],200);
    }

    private function checkIfDataAvalibale($request)
    {
        if($request->country_id||$request->nationality_id)
        {
            $data = Country::find($request->country_id??$request->nationality_id);
            if(!$data) return 'country not found';
        }
        if($request->influncer_category_id)
        {
            $data = InfluncerCategory::find($request->influncer_category_id);
            if(!$data) return 'category not found';
        }
        if($request->city_id)
        {
            $data = City::find($request->city_id);
            if(!$data) return 'city not found';
        }
        if((isset($request->categories)&&count($request->categories) < 3) || (isset($request->categories)&&count($request->categories) > 3))
        {
            return 'should be 3 categories for the influencer';
        }

        return null;
    }

  


}
