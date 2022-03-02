<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\InfluncerRequest;
use App\Http\Requests\Api\CustomerRequest;
use App\Models\User;
use App\Models\Influncer;
use App\Models\Customer;
use App\Notifications\AddInfluencer;

class RegisterController extends Controller
{
    public function registerInfluncer(InfluncerRequest $request)
    {
        $info =[
            'msg'=>$request->message,
        ];
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
            'category_id',
            'nationality_id',
            'influncer_category_id',
            'user_id',
        ]);

       $addUserId =  array_merge($influncerData,['user_id'=>$data->id]);
        $newInfluncer = Influncer::create($addUserId);
        $sendTo = User::find($data->id);
        $sendTo->notify(new AddInfluencer($info));

        return response()->json([
            'msg'=>'Influncer was created',
            'status'=>201
        ],201);
    }

    public function registerCustomer(CustomerRequest $request)
    {
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
            'user_id',
        ]);
        $addUserId =  array_merge($customerData,['user_id'=>$data->id]);
        $newInfluncer = Customer::create($addUserId);
        $sendTo = User::find($data->id);
        $sendTo->notify(new AddInfluencer($info));
        return response()->json([
            'msg'=>'Customer was created',
            'status'=>201
        ],201);
    }


}
