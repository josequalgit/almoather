<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $data = Country::get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code
            ];
        });
        return response()->json([
            'msg'=>'all the countries avalibale',
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
