<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Auth,Alert;

class AdController extends Controller
{
    public function index()
    {
        $data = Ad::paginate(10);
        $counter = Ad::count();
        return view('dashboard.ads.index',compact('data','counter'));
    }

    public function edit($id)
    {
        $data = Ad::findOrFail($id);
        return view('dashboard.ads.edit',compact('data'));
    }

    public function update(Request $request , $id)
    {
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'msg'=>'ad not found',
            'status'=>200
        ],200);
        if(!$request->status) return response()->json([
            'msg'=>'please add a status',
            'status'=>401
        ],401);
        $data->status = $request->status;
        $data->reject_note = $request->note ?? null;
        $data->save();


        activity()->log('Admin "'.Auth::user()->name.'" Updated ad"'. $data->store .'" to "'.$data->status.'" status');
        Alert::toast('Add was updated', 'success');


        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ],201);
    }
}
