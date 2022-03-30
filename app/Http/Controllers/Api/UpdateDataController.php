<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Http\Requests\Api\UpdateInfulncerRequest;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Models\Country;
use App\Models\City;
use App\Models\InfluncerCategory;
use Auth;
use App\Http\Traits\UserResponse;
use App\Models\Influncer;
use App\Models\SocialMediaProfile;


class UpdateDataController extends Controller
{
    use UserResponse;
   
    public function updateCustomer(UpdateCustomerRequest $request , $id)
    {
        $data = User::find(Auth::guard('api')->user()->id);

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
        
        if(!$data->customers)
        {
            return response()->json([
                'msg'=>'user is not a customer',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        $updateUser = [];
        if($request->password)
        {
            $updateUser['password'] = bcrypt($request->password);
        }
        if($request->email !== $data->email)
        {
            $checkEmail = User::where('email',$request->email)->first();
            if($checkEmail)
            {
                return response()->json([
                    'msg'=>'email was already found',
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }
            $updateUser['email'] = $request->email;
        }

        $data->update($updateUser);
        
        
        if($request->hasFile('image')){
            $data->clearCollection('customers')
            ->addMedia($request->file('image'))
            ->toMediaCollection('customers');
        }

        $customerData = $request->only([
                    'first_name',
                    'last_name',
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
            'data'=>$this->userDataResponse($data),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function updateInfluncer(UpdateInfulncerRequest $request , $id)
    {
        $data = User::find(Auth::guard('api')->user()->id);

        $info =[
            'msg'=>$request->message,
        ];
        if($this->checkIfDataAvalibale($request))
        {
            return response()->json([
                'msg'=>$this->checkIfDataAvalibale($request),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

        $commingRequest =  array_merge($request->only(['email','password','name']),['password'=>bcrypt($request->password)]);

        if(!$data->influncers)
        {
            return response()->json([
                'msg'=>'influencer not found',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        
        if($request->password)
        {
            $updateUser['password'] = bcrypt($request->password);
        }
        if($request->email !== $data->email)
        {
            $checkEmail = User::where('email',$request->email)->first();
            if($checkEmail)
            {
                return response()->json([
                    'msg'=>'email was already found',
                    'status'=>config('global.WRONG_VALIDATION_STATUS')
                ],config('global.WRONG_VALIDATION_STATUS'));
            }
            $updateUser['email'] = $request->email;
        }

        $data->update($updateUser);

        if($request->hasFile('image'))
        {

            $data->clearCollection('customers')
            ->addMedia($request->file('image'))
            ->toMediaCollection('influncers');
        }

        if($request->hasFile('commercial_registration_no_files'))
        {

            $data->clearCollection('customers')
            ->addMedia($request->file('commercial_registration_no_files'))
            ->toMediaCollection('commercial_registration_no_files');
        }

        if($request->hasFile('tax_registration_number_file'))
        {

            $data->clearCollection('customers')
            ->addMedia($request->file('tax_registration_number_file'))
            ->toMediaCollection('tax_registration_number_file');
        }

        if($request->snap_chat_video)
        {

            $data->clearCollection('snapchat_videos');
        }

        if($request->snap_chat_video)
        {
            foreach ($request->snap_chat_video as $value) {
                $data->addMedia($value)
                ->toMediaCollection('snapchat_videos');
            }
        }
        

        $influncerData = $request->only([
            'full_name',
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
            'bank_id',
            'snap_chat_views',
            'snap_chat_video'
        ]);

       $addUserId =  array_merge($influncerData,['user_id'=>$data->id]);
       $addTranslate =  array_merge($addUserId,['full_name'=>[
           'ar'=>$request->full_name_ar,
           'en'=>$request->full_name_en
       ]]);
       $newInfluncer = Influncer::find($data->influncers->id);
       $newInfluncer->update($addTranslate);

       $newInfluncer->InfluncerCategories()->detach();


       foreach($request->categories as $item)
       {
           $newInfluncer->InfluncerCategories()->attach($item);
       }

       $newInfluncer->socialMedias()->detach();

       foreach($request->preferred_socialMedias as $item)
       {
           $newInfluncer->socialMedias()->attach($item);
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
            'msg'=>'New Influncer "'.$newInfluncer->full_name.'" registered'
        ];
        Notification::send($users, new AddInfluencer($info));
        $info = $data->influncers;
        $token = Auth::guard('api')->attempt(['email'=>$request->email,'password'=>$request->password]);

        return response()->json([
            'msg'=>'Influncer was updated',
            'data'=>$this->userDataResponse($data),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
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
