<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

class CityController extends Controller
{
    public function index($id)
    {
        $data = Region::find($id);
        if(!$data) return response()->json([
            'err'=>"Area dose't exist",
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        return response()->json([
            'msg'=>'all cities belongs to '.$data->name,
            'data'=>$data->cities()->get()->map(function($item){
                return [
                    'id'=>$item->id,
                    'name'=>$item->name,
                ];
            }),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
