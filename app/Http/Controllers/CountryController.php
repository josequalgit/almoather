<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index($id)
    {
        $data = Country::find($id);
        if(!$data) return response()->json([
            'msg'=>'country not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'all countries',
            'data'=>$data->areas,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
