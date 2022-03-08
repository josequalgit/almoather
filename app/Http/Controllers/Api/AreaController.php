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
            'status'=>404
        ],404);
        return response()->json([
            'msg'=>'areas for '.$data->name.' city',
            'data'=>$data->areas()->select(['id','name'])->get(),
            'status'=>200
        ]);
    }
}
