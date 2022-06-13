<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
class RegionController extends Controller
{
    public function index($country_id)
    {
        $data = Region::where('country_id',$country_id)->get();

        return response()->json([
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
