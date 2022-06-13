<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;

class CityController extends Controller
{

    public function index()
    {
        $data = City::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));

        return view('dashboard.cities.index',compact('data'));
    }

    public function get_city_according_to_country($id)
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
