<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class AreaController extends Controller
{
    public function index($id)
    {
        $data = Country::find($id);
        if(!$data) return response()->json([
            'err'=>'city not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $cities = $data->areas()->get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });

        return response()->json([
            'msg'=>'areas for '.$data->name.' country',
            'data'=>$cities,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
