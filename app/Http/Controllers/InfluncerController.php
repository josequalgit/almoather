<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influncer;
use Alert,Auth;
use Carbon\Carbon;

class InfluncerController extends Controller
{
    public function index()
    {
        $data = Influncer::with('users')->paginate(10);
        $counter = Influncer::with('users')->count();
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



        return view('dashboard.influncers.index',compact('data','counter','influncersData'));
    }

    public function edit($id)
    {
        $data = Influncer::findOrFail($id);

        return view('dashboard.influncers.edit',compact('data'));
    }

    public function updateStatus(Request $request , $id)
    {
        $data = Influncer::find($id);
        if(!$data) return response()->json([
            'err'=>'Influncer not found',
            'status'=>404
        ],200);
        $data->status = $request->status;
        $data->rejected_note = $request->note ??  null ;
        $data->save();
        activity()->log('Admin "'.Auth::user()->name.'" changed "'. $data->full_name_en .'" influncer status');
        Alert::toast('Influncer status was changed', 'success');

        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ]);
    }
}
