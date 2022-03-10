<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class RegionController extends Controller
{
   public function index($id)
   {
    $data = Country::find($id);
    if(!$data) return response()->json([
        'err'=>"Country dose't exist",
        'status'=>404
    ],404);

    return response()->json([
        'msg'=>'all regions belongs to '.$data->name,
        'data'=>$data->regions()->select(['id','name'])->get(),
        'status'=>200
    ],200);
   }
}
