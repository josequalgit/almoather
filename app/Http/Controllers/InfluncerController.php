<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influncer;
use App\Models\InfluncerCategory;
use Alert,Auth;
use Carbon\Carbon;

class InfluncerController extends Controller
{
    public function index($status = null)
    {
        $data = Influncer::with('users');
        $allStatus = ['pending','accepted','rejected','band'];
        if($status) $data->where('status',$status);
        $counter = $data->count();
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $year = Carbon::now()->year;
        $influncersData = [];

        foreach($months as $month)
        {
            $influncerNumber = Influncer::whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
            array_push($influncersData,$influncerNumber);
        }

       $data =  $data->orderBy('created_at','desc')->paginate(10);
       if(!in_array($status,$allStatus)) $status = null;

        return view('dashboard.influncers.index',compact('data','counter','influncersData','status'));
    }

    public function edit($id)
    {
        $data = Influncer::findOrFail($id);
        $infCategories = $data->InfluncerCategories->pluck('id')->toArray();
        $categories = InfluncerCategory::get();
        //return $infCategories;
        return view('dashboard.influncers.edit',compact('data','categories','infCategories'));
    }

    public function updateStatus(Request $request , $id)
    {
     //   return $request->categories;
        $data = Influncer::find($id);
        if(!$data) return response()->json([
            'err'=>'Influncer not found',
            'status'=>404
        ],200);
        $data->status = $request->status;
        $data->rejected_note = $request->note ??  null ;
        $data->save();
        $data->InfluncerCategories()->detach();

        foreach($request->categories as $item)
        {
            $data->InfluncerCategories()->attach($item);
        }
        activity()->log('Admin "'.Auth::user()->name.'" changed "'. $data->full_name_en .'" influncer status');
        Alert::toast('Influncer status was changed', 'success');

        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ]);
    }

    public function allInfluncerWithViews ()
    {
        $data = Influncer::paginate(10);

        return view('dashboard.influncers.allWithView',compact('data'));
    }
}
