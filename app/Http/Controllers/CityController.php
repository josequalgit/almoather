<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use Alert;

class CityController extends Controller
{

    public function index()
    {
        $data = City::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        $countries = Country::get();
        return view('dashboard.cities.index',compact('data','countries'));
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
            'data'=>$data->cities()->map(function($item){
                return[
                    'id'=>$item->id,
                    'name'=>$item->name,
                ];
            }),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function store(Request $request)
    {
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);

        City::create($addTranslation);
        Alert::toast('City was created', 'success');
        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'city was created'
        ],config('global.OK_STATUS'));
    }

    public function update(Request $request , $id)
    {
        $city = City::find($id);
        if(!$city) return response()->json([
            'msg'=>'city not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.OK_STATUS'));
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);
        $city->update($addTranslation);
        Alert::toast('City was updated', 'success');

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'city was updated'
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        $city = City::find($id);
      
        if(!$city) return response()->json([
            'status'=>config('global.NOT_FOUND_STATUS'),
            'msg'=>'city not found',
        ],config('global.OK_STATUS'));
        if($city->ads&&count($city->ads) > 0){
            Alert::toast('The City have ads', 'error');
            return back();
        }
        $city->delete();
        Alert::toast('City was deleted', 'success');
        return response()->json([
            'msg'=>'city was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }
}
