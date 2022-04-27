<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class CityController extends Controller
{
    public function index($id)
    {
        $data = Area::find($id);
        if(!$data) return response()->json([
            'msg'=>'area not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'all cities',
            'data'=>$data->cities,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
