<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Requests\Api\AdRequest;
use Auth;

class AdController extends Controller
{
    protected $guard = 'api';

    public function store(AdRequest $request)
    {
        
        #CHECK REQUEST 
        if(!$request->hasFile('documnet')&&!$request->auth_number)
        {
            return response()->json([
                'msg'=>'please upload a document or add the authentication number',
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

        return response()->json([
            'msg'=>'ad was created',
            'status'=>201
        ],201);
    }
}
