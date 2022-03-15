<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CityController extends Controller
{
    public function index($id)
    {
        $data = Country::find($id);
        if(!$data) return response()->json([
            'err'=>"Country dose't exist",
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'=>'all cities belongs to '.$data->name,
            'data'=>$data->cities()->select(['id','name'])->get(),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
