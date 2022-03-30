<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class AreaController extends Controller
{
    public function index($id)
    {
        $data = City::find($id);
        if(!$data) return response()->json([
            'err'=>'city not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'=>'areas for '.$data->name.' city',
            'data'=>$data->areas()->select(['id','name'])->get(),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
