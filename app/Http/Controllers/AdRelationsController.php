<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Relation;
use Alert;

class AdRelationsController extends Controller
{
    public function index()
    {

        $data = Relation::orderBy('created_at','desc')->paginate(10);      
        return view('dashboard.adsRelations.index',compact('data'));
    }

    public function update(Request $request ,$id)
    {
        $data = Relation::findOrFail($id);
        $data->update(
            [
                'title'=>[
                    'ar'=>$request->relation_ar,
                    'en'=>$request->relation_en
                ],
                'app_profit'=>$request->app_profit
            ]
        );

        Alert::toast('update ad relation', 'success');

        return response()->json([
            'msg'=>trans('messages.api.data_was_updated'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function store(Request $request)
    {
        Relation::create([
            'title'=>[
                'ar'=>$request->relation_ar,
                'en'=>$request->relation_en
            ],
            'app_profit'=>$request->app_profit
        ]);
        Alert::toast('ad relation was created', 'success');
        return response()->json([
            'msg'=>trans('messages.api.data_was_updated'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        Relation::destroy($id);
        Alert::toast('ad relation was deleted', 'success');
         return response()->json([
            'msg'=>trans('messages.api.data_was_updated'),
            'status'=>config('global.UPDATED_STATUS')
        ],config('global.UPDATED_STATUS'));

    }
}
