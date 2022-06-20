<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Reason;
use Alert;

class ReasonsController extends Controller
{
    public function index()
    {
        $data = Reason::paginate(10);
        return view('dashboard.reasons.index',compact('data'));
    }


    public function store(Request $request)
    {
        $data = array_merge($request->all(),['text'=>[
            'ar'=>$request->reason_ar,
            'en'=>$request->reason_en,
        ]]);
        Reason::create($data);
        
        Alert::toast('Reason Was added', 'success');
        return response()->json([
            'msg'=>'reason was added',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }


    public function update(Request $request,$id)
    {
        $request_data = array_merge($request->all(),['text'=>[
            'ar'=>$request->reason_ar,
            'en'=>$request->reason_en,
        ]]);
        $data = Reason::findOrFail($id);

        $data->update($request_data);
        
        Alert::toast('Reason Was updated', 'success');
        return response()->json([
            'msg'=>'reason was updated',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }



    public function delete($id)
    {
 
        $data = Reason::find($id);
        if(!$data) return response()->json([
            'msg'=>'data not found',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
        $data->delete();
        Alert::toast('Reason Was deleted', 'success');

        return response()->json([
            'msg'=>'reason was deleted',
            'status'=>config('global.OK_STATUS'),
        ],config('global.OK_STATUS'));
    }
}
