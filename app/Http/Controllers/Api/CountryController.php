<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $data = Country::select(['id','name','code'])->get();
        return response()->json([
            'msg'=>'all the countries avalibale',
            'data'=>$data
        ]);
    }
}
