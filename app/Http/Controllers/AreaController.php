<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Country;
use Alert;

class AreaController extends Controller
{
    public function index()
    {
        $data = Region::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        $countries = Country::get();

        return view('dashboard.areas.index',compact('data','countries'));
    }

    public function store(Request $request)
    {
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);
        Region::create($addTranslation);
        Alert::toast('Area was created', 'success');

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'area was created'
        ],config('global.OK_STATUS'));
    }

    public function update(Request $request , $id)
    {
        
        $city = Region::find($id);
        if(!$city) return response()->json([
            'msg'=>'city not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.OK_STATUS'));
        $addTranslation = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en,
        ]]);
        $city->update($addTranslation);
        Alert::toast('Area was updated', 'success');

        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'msg'=>'area was updated'
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        $city = Region::find($id);
        if(!$city) return response()->json([
            'status'=>config('global.NOT_FOUND_STATUS'),
            'msg'=>'city not found',
        ],config('global.OK_STATUS'));
        $city->delete();
        Alert::toast('Area was deleted', 'success');
        return response()->json([
            'msg'=>'area was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

}
