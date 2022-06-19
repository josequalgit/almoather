<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Alert;

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

    public function all()
    {
        $data = Country::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
     
        return view('dashboard.countries.index',compact('data'));
    }


    public function store(Request $request)
    {
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);
        Country::create($addTranslation);
        Alert::toast('Country was created', 'success');

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'area was created'
        ],config('global.OK_STATUS'));
    }

    public function update(Request $request , $id)
    {
        $city = Country::find($id);
        if(!$city) return response()->json([
            'msg'=>'city not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.OK_STATUS'));
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);
        $city->update($addTranslation);
        Alert::toast('Country was updated', 'success');

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'Country was updated'
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        $city = Country::find($id);
        if(!$city) return response()->json([
            'status'=>config('global.NOT_FOUND_STATUS'),
            'msg'=>'city not found',
        ],config('global.OK_STATUS'));
        if($city->ads&&count($city->ads) > 0){
            Alert::toast('The Country have ads', 'error');
            return back();
        }
        $city->delete();
        Alert::toast('Country was deleted', 'success');
        return response()->json([
            'msg'=>'Country was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

}
