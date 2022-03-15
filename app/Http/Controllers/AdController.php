<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Auth,Alert;

class AdController extends Controller
{
    public function index($status = null)
    {
        $data = Ad::where('status',$status)->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        $counter = Ad::where('status',$status)->count();
        if(!$status)
        {
            $data = Ad::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
            $counter = Ad::count();
        }
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
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
        if(!$request->status) return response()->json([
            'msg'=>'please add a status',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        if(!$request->expense_type) return response()->json([
            'msg'=>'please add a type',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

        $influencers = $data->categories->influncerCategories[0]->influncers;

        return response()->json([$influencers[0]->verify],500);
     //   $influencers = [];
        // foreach ($categories as $category) {
        //     return response()->json([$category],500);

        //     foreach ($category->influncers as $key => $influencer) {
        //         if(!in_array($influencer->id,array_keys($influencers))){
        //             $influencers[$influencer->id] = $influencer;
        //         }
        //     }
            
        // }
        return response()->json([$influencers],500);

        $data->status = $request->status;
        $data->reject_note = $request->note ?? null;
        $data->expense_type = $request->expense_type;
        $data->save();


        activity()->log('Admin "'.Auth::user()->name.'" Updated ad"'. $data->store .'" to "'.$data->status.'" status');
        Alert::toast('Add was updated', 'success');


        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ],201);
    }
}
