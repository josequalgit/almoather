<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\InfluncerRequest;
use App\Http\Requests\Api\CustomerRequest;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Http\Requests\Api\CheckUniqeDataRequest;
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
use Auth;
use App;
use App\Http\Traits\UserResponse;

class RegisterController extends Controller
{
    use UserResponse;

    public function registerInfluncer(InfluncerRequest $request)
    {
        $info =[
            'msg'=>$request->message,
        ];

        $available = $this->checkIfDataAvalibale($request);
        if($available)
        {
            return response()->json([
                'msg'       => $available,
                'status'    => config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        $commingRequest =  array_merge($request->only(['email','password','dial_code','name','fcm_token','phone','country_code']),['password' => bcrypt($request->password)]);
        $data = User::create($commingRequest);


        $influncerData = $request->only([
            'first_name',
            'middle_name',
            'last_name',
            'bank_id',
            'nick_name',
            // 'bank_name',
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
            'ad_with_vat',
            'ad_onsite_price_with_vat',
            // 'birthday',
            'bank',
            'snap_chat_views',
            'snap_chat_video',
            'commercial_registration_no',
            'tax_registration_number',
          
            'rep_full_name',
            'rep_email_name',
            'rep_phone_number',
            'rep_city',
            'rep_area',
            'rep_street',
            'snap_chat_video',
            'milestone',
            'street',
            'neighborhood',
            'bank_account_name',
        ]);
        

       $addUserId =  array_merge($influncerData,['user_id'=>$data->id]);
       $addTranslate =  array_merge($addUserId,['full_name'=>[
           'ar' => $request->full_name_ar,
           'en' => $request->full_name_en
       ]]);

       if(!$request->tax_registration_number)
       {
        $addTranslate  = array_merge($addTranslate,['tax_registration_number'=>0]);
       }

       $newInfluncer = Influncer::create($addTranslate);

       $data->addMedia($request->file('image'))
       ->toMediaCollection('influncers');
       
       $newInfluncer->addMedia($request->file('snap_video'))
       ->toMediaCollection('snap_video');

       if($request->hasFile('cr_file'))
       {
           $newInfluncer->addMedia($request->file('cr_file'))
           ->toMediaCollection('cr_file');
       }
    //    if($request->hasFile('tax_registration_number_file'))
    //    {
    //        $newInfluncer->addMedia($request->file('tax_registration_number_file'))
    //        ->toMediaCollection('tax_registration_number_file');
    //    }

       
        //    foreach ($request->snap_chat_video as $value) {
        //        $data->addMedia($value)
        //        ->toMediaCollection('snapchat_videos');
        //    }

       foreach($request->categories as $item)
       {
           $newInfluncer->InfluncerCategories()->attach($item);
       }

        // removed
        //    foreach($request->preferred_socialMedias as $item)
        //    {
        //        $newInfluncer->socialMedias()->attach($item);
        //    }


       foreach ($request->social_media as $item) {
            $obj = $item;
           if(!is_object($item)) $obj = (object)$item;
            SocialMediaProfile::create([
                'link'              => $obj->link,
                'views'              => $obj->views ?? 0,
                'social_media_id'   => $obj->type,
                'Influncer_id'      => $newInfluncer->id
            ]);
       }

        $users = [User::find(1)];
       $fullName = $newInfluncer->first_name.' '.$newInfluncer->middle_name.' '.$newInfluncer->last_name;
        $info =[
            'msg'=>'New Influncer "'.$fullName.'" registered'
        ];
        Notification::send($users, new AddInfluencer($info));

        $info = $data->influncers;
        $token = Auth::guard('api')->attempt(['email' => $request->email,'password' => $request->password]);
        
        //dd($info);

        return response()->json([
            'msg'       => 'Influncer was created',
            'data'      => $this->userDataResponse($data , $token,$data->id),
            'status'    => config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function registerCustomer(CustomerRequest $request)
    {
        
        if($this->checkIfDataAvalibale($request))
        {
            return response()->json([
                'msg'=>$this->checkIfDataAvalibale($request),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        $info =[
            'msg'=>$request->message,
        ];
        $commingRequest =  array_merge($request->only(['email','password','dial_code','name','fcm_token','phone','country_code']),['password'=>bcrypt($request->password)]);
        $data = User::create($commingRequest);
        if($request->hasFile('image'))
        {
            $data->addMedia($request->file('image'))
            ->toMediaCollection('customers');
        }
       
        $customerData = $request->only([
            'first_name',
            'middle_name',
            'last_name',
            'id_number',
            'country_id',
            'nationality_id',
            'region_id',
            'user_id',
            'city_id',
            'gender'
        ]);
        $addUserId =  array_merge($customerData,['user_id'=>$data->id]);
        $newCustomer = Customer::create($addUserId);
       

        $users = [User::find(1)];
        $info =[
            'msg'=>'New Customer "'.$newCustomer->first_name.'" registered'
        ];
        Notification::send($users, new AddInfluencer($info));
        $info = $data->customers;
        $token = Auth::guard('api')->attempt(['email'=>$request->email,'password'=>$request->password]);

        return response()->json([
            'msg'=>'Customer was created',
            'data'=>$this->userDataResponse($data , $token,$data->id),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function verify()
    {
        $data = User::find(Auth::guard('api')->user()->id);
        
        # IF THE USER IS NOT FOUND 
        if(!$data) return response()->json([
            'err'=>'user not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        #IF THE USER ALREADY VERIFIED
        if($data->email_verified_at) return response()->json([
            'err'=>'user already verified',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        #UPDATE THE USER
        $data->email_verified_at = Carbon::parse()->now();
        $data->save();


        #RETURN WITH 200 STATUS CODE
        return response()->json([
            'msg'=>'user is verified',
            'data'=>$this->userDataResponse(null , null ,Auth::guard('api')->user()->id ),
            'type'=>Auth::guard('api')->user()->customers?'customer':'Influencer',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
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
        if(isset($request->isVat)&&!$request->tax_registration_number)
        {
            return 'should be 3 categories for the influencer';
        }

        return null;
    }

    public function updateCustomer(UpdateCustomerRequest $request , $id)
    {
        if($this->checkIfDataAvalibale($request))
        {
            return response()->json([
                'msg'=>$this->checkIfDataAvalibale($request),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        $info =[
            'msg'=>$request->message,
        ];
        $commingRequest =  array_merge($request->only(['email','password','name']),['password'=>bcrypt($request->password)]);
        $data = User::find($id);
        $data->update($commingRequest);
        if($request->hasFile('image')){
            $data->clearCollection('customers')
            ->addMedia($request->file('image'))
            ->toMediaCollection('customers');
        }

        $customerData = $request->only([
            'full_name',
            'phone',
            'country_id',
            'nationality_id',
            'region_id',
            'user_id',
            'city_id',
            'id_number'
        ]);
        $addUserId =  array_merge($customerData,['user_id'=>$data->id]);
        $newCustomer = Customer::find($data->customers->id);
        $newCustomer->update($addUserId);
       

        $users = [User::find(1)];
        $info =[
            'msg'=>'Customer "'.$newCustomer->first_name.'" was updated'
        ];
        Notification::send($users, new AddInfluencer($info));
        $info = $data->customers;
        $token = Auth::guard('api')->attempt(['email'=>$request->email,'password'=>$request->password]);

        return response()->json([
            'msg'=>'Customer was updated',
            'data'=>$this->userDataResponse($data , $token,$data->id),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }  


    public function checkUniqueData(CheckUniqeDataRequest $request)
    {
        $checkEmail = User::where('email',$request->email)->first();
        $checkPhone = User::where('phone',$request->phone)->first();

        if($checkEmail)
        {
            return response()->json([
                'msg'=>'email already exist',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        if($checkPhone)
        {
            return response()->json([
                'msg'=>'phone number already exist',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }


        return response()->json([
            'msg'=>'email and phone available',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
      

       
    }


}
