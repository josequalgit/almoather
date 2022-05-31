<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Http\Requests\Api\UpdateInfulncerRequest;
use App\Http\Requests\Api\UpdatePersonalDataRequest;
use App\Http\Requests\Api\UpdateMediaDetailsRequest;
use App\Http\Requests\Api\UpdatePriceInfluncerRequest;
use App\Http\Requests\Api\UpdateExtraInfluncerRequest;
use App\Http\Requests\Api\UpdateSubscribersRequest;
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
use App\Models\Bank;
use App\Models\SocialMediaProfile;
//use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;


class UpdateDataController extends Controller
{
    use UserResponse;
   
    public function updateCustomer(UpdateCustomerRequest $request)
    {
        if(!Auth::guard('api')->user())  return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

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
        $commingRequest =  array_merge($request->only(['email','password','name','phone','country_code']),['password'=>bcrypt($request->password)]);
        
        if(!$data->customers)
        {
            return response()->json([
                'msg'=>'user is not a customer',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }
        $updateData['phone'] = $request->phone;
        $updateData['country_code'] = $request->country_code;
        $updateData['dial_code'] = $request->dial_code;

        // $updateUser = [];
        // if($request->password)
        // {
        //     $updateUser['password'] = bcrypt($request->password);
        // }
        // if($request->email !== $data->email)
        // {
        //     $checkEmail = User::where('email',$request->email)->first();
        //     if($checkEmail)
        //     {
        //         return response()->json([
        //             'msg'=>'email was already found',
        //             'status'=>config('global.WRONG_VALIDATION_STATUS')
        //         ],config('global.WRONG_VALIDATION_STATUS'));
        //     }
        //     $updateUser['email'] = $request->email;
        // }

        $data->update($updateData);
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
        $newCustomer = Customer::find($data->customers->id);
        $newCustomer->update($addUserId);
       

        $users = [User::find(1)];
        $info =[
            'msg'=>'Customer "'.$newCustomer->first_name.'" was updated',
            'id'=>$data->id,
            'type'=>'Customer'
            
        ];
        Notification::send($users, new AddInfluencer($info));
        $info = $data->customers;
        $token = Auth::guard('api')->attempt(['email'=>$request->email,'password'=>$request->password]);

        return response()->json([
            'msg'=>'Customer was updated',
            'data'=>$this->userDataResponse($data,null,$data->id),
            'status'=>config('global.CREATED_STATUS')
        ],config('global.CREATED_STATUS'));
    }

    public function updateInfluncer(UpdatePersonalDataRequest $request , $id)
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

        $commingRequest =  array_merge($request->only(['email','password','name','phone']),['password'=>bcrypt($request->password)]);

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
        $updateData['phone'] = $request->phone;
        $updateData['country_code'] = $request->country_code;
        // if($request->email !== $data->email)
        // {
        //     $checkEmail = User::where('email',$request->email)->first();
        //     if($checkEmail)
        //     {
        //         return response()->json([
        //             'msg'=>'email was already found',
        //             'status'=>config('global.WRONG_VALIDATION_STATUS')
        //         ],config('global.WRONG_VALIDATION_STATUS'));
        //     }
        //     $updateUser['email'] = $request->email;
        // }

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
            // 'bank_name',
            'bank_account_number',
            'bio',
            'bank_account_first_name',
            'bank_account_middle_name',
            'bank_account_last_name',
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
            'birthday',
            'address_id',
            'bank_id',
            // 'snap_chat_views',
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
            'data'=>$this->userDataResponse($data,null,$data->id),
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

    public function updatePersonalInfluncerData(UpdatePersonalDataRequest $request)
    {
        if(!Auth::guard('api')->user()) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $data = User::find(Auth::guard('api')->user()->id);


        // if($request->hasFile('image')){
        //     $data->clearMediaCollection('influncers')
        //     ->addMedia($request->file('image'))
        //     ->toMediaCollection('influncers');
        // }

        if(!$data) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        if(!$data->influncers) return response()->json([
            'msg'=>'influencer not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $inf = Influncer::find($data->influncers->id);

        $inf->first_name = $request->first_name;
        $inf->middle_name = $request->middle_name;
        $inf->last_name = $request->last_name;
        $inf->country_id = $request->country_id;
        $inf->nationality_id = $request->nationality_id;
        $inf->id_number = $request->id_number;
        $inf->city_id = $request->city_id;
        $inf->is_vat = $request->is_vat;
        $inf->region_id = $request->region_id;
        $data->phone = $request->phone;
        $data->dial_code = $request->dial_code;
        $data->country_code = $request->country_code;

        $data->save();
        $inf->save();

        

        return response()->json([
            'msg'=>'data was update',
            'data'=>$this->userDataResponse($data,null,$data->id),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function updateMediaDetailsInfluncer(UpdateMediaDetailsRequest $request)
    {

        if(!Auth::guard('api')->user())return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $user = User::find(Auth::guard('api')->user()->id);

        if(!Auth::guard('api')->user()) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        if(!$user) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));


        if(!$user->influncers) return response()->json([
            'msg'=>'influencer not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $inf = Influncer::find($user->influncers->id);

        $updateData = $inf->update([
            'nick_name'=>$request->nick_name,
            'bio'=>$request->bio,
            'ads_out_country'=>$request->ads_out_country,
            'ad_with_vat'=>$request->ad_with_vat,
            'ad_onsite_price_with_vat'=>$request->ad_onsite_price_with_vat,
            'ad_price'=>$request->ad_price,
            'ad_onsite_price'=>$request->ad_onsite_price
        ]);
        

       

        $inf->socialMedias()->detach();

        $social = SocialMediaProfile::where('Influncer_id',$inf->id)->get();

        foreach ($social as $item) {
            $data = SocialMediaProfile::find($item->id);
            $data->delete();
        }

        foreach($request->social_media as $item)
        {
            if(!is_object($item)) $obj = (object)$item;
            SocialMediaProfile::create([
                'link'=>$obj->link,
                'social_media_id'=>$obj->type,
                'views'=> $obj->views,
                'Influncer_id'=>$inf->id
            ]);
        }

        $inf->InfluncerCategories()->detach();

        foreach ($request->categories as $item) {
             $inf->InfluncerCategories()->attach($item);
        }
        $inf->socialMedias()->detach();

        // foreach ($request->preferred_socialMedias as $item) {
        //      $inf->socialMedias()->attach($item);
        // }
        
      

       


        return response()->json([
                    'msg'=>'data was update',
                    'data'=>$this->userDataResponse($user,null,$user->id),
                    'status'=>config('global.OK_STATUS')
                ],config('global.OK_STATUS'));
        
    }

    public function updateExtraInfoInfluencers(UpdateExtraInfluncerRequest $request)
    {
        if(!Auth::guard('api')->user())return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $user = User::find(Auth::guard('api')->user()->id);

        if(!$user) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));


        if(!$user->influncers) return response()->json([
            'msg'=>'influencer not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $inf = Influncer::find($user->influncers->id);

        $updateData = $inf->update([
            'rep_full_name'=>$request->rep_full_name,
            'rep_phone_number'=>$request->rep_phone_number,
            'milestone'=>$request->milestone,
            'rep_city'=>$request->rep_city,
            'rep_area'=>$request->rep_area,
            'street'=>$request->street,
            'neighborhood'=>$request->neighborhood
        ]);

   
        return response()->json([
            'msg'=>'data was update',
            'data'=>$this->userDataResponse($user,null,$user->id),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));


    }

    public function updatePriceInfoInfluencers(UpdatePriceInfluncerRequest $request)
    {
        if(!Auth::guard('api')->user())return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        
        $user = User::find(Auth::guard('api')->user()->id);

    
        if(!$user) return response()->json([
            'msg'=>'user not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));


        if(!$user->influncers) return response()->json([
            'msg'=>'influencer not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $inf = Influncer::find($user->influncers->id);
        $bank = Bank::find($request->bank_id);
        if(!$bank) return response()->json([
            'msg'=>'bank not found',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));
        
        $updateData = $inf->update([
            'bank_id'=>$request->bank_id,
            'bank_account_number'=>$request->bank_account_number,
            'bank_account_name'=>$request->bank_account_name,
            'commercial_registration_no'=>$request->commercial_registration_no,
            'tax_registration_number'=>$request->tax_registration_number,
            'is_vat'=>$request->is_vat,
        ]);

        return response()->json([
            'msg'=>'data was update',
            'data'=>$this->userDataResponse($user,null,$user->id),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    public function deleteFiles($id)
    {
        $media = DB::table('media')->where('id',$id)->first();

        if(!$media)return response()->json([
            'err'=>'file not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        Storage::deleteDirectory(public_path('storage/'.$media->model_id.'/'.$media->file_name));


        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);

        return response()->json([
            'msg'=>'file was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    public function uploadFiles(Request $request,$type)
    {
        /**
         *  type =>
         *  1=> upload image 
         *  2=> upload registration  commercial
         *  3=> upload registration  tax
         *  4=> upload snapchat_videos
         */

        if(!Auth::guard('api')->user())return response()->json([
            'err'=>'user not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $user = User::find(Auth::guard('api')->user()->id);

        $inf = $user->influncers;

     

    
        if($user->customers)
        {
            $file = null;
            if($request->hasFile('file')){
                $user->clearMediaCollection('customers');
                
                $file = $user->addMedia($request->file('file'))
                ->toMediaCollection('customers');
            }

            return response()->json([
                'status'=>config('global.OK_STATUS'),
                // 'data'=>$this->userDataResponse($user,null,$user->id)
                'data'=>[
                    'id'=>$file->id,
                    'url'=>$file->getFullUrl()
                ],
            ],config('global.OK_STATUS'));
        }

        if(!$request->hasFile('file')) return response()->json([
            'err'=>'Please add a file',
            'status'=>config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS'));

        $file = [];

        if($type == 1)
        {
            $user->clearMediaCollection('influncers');
            $file = $user->addMedia($request->file('file'))
            ->toMediaCollection('influncers');
        }
        if($type == 2)
        {
            $inf->clearMediaCollection('cr_file');
            $file =  $inf->addMedia($request->file('file'))
            ->toMediaCollection('cr_file');
        }
        // if($type == 3)
        // {
        //     $inf->clearMediaCollection('tax_registration_number_file');
        //     $file = $inf->addMedia($request->file('file'))
        //     ->toMediaCollection('tax_registration_number_file');
        // }
        // if($type == 4)
        // {
        //     $file = $inf->addMedia($request->file('file'))
        //     ->toMediaCollection('snap_video');
        // }


        return response()->json([
            'status'=>config('global.OK_STATUS'),
            // 'data'=>$this->userDataResponse($user,null,$user->id)
            'data'=>[
                'id'=>$file->id,
                'url'=>$file->getFullUrl()
            ],
        ],config('global.OK_STATUS'));

    }

    public function updateSubscribers(UpdateSubscribersRequest $request)
    {
        $data = [
            'subscribers'=>  $request->subscribers,
            'subscribers_update'=>Carbon::now(),
        ];
        $inf = Auth::guard('api')->user()->influncers;
        

        if(!$inf) return response()->json([
            'msg'=>'user is not an influencer',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $inf->update($data);

        return response()->json([
            'msg'=>'data was updated',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
    
    
}
