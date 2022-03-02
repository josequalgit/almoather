<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialMedia;
use Alert,
Auth;

class SocialMediaController extends Controller
{
    public function index()
    {
        $data = SocialMedia::paginate(10);
        return view('dashboard.socialMedias.index',compact('data'));
    }

    public function update($id)
    {
        $data = SocialMedia::find($id);
        if(!$data) return response()->json([
            'msg'=>'data not found',
            'status'=>200
        ],200);
        $data->active = !$data->active;
        $data->save();
        $status = $data->active ? 'Active':'Not active';
        activity()->log('Admin "'.Auth::user()->name.'" changed "'. $data->name .'" status to "'.$status.'"' );
        Alert::toast('Data was updated', 'success');


        return response()->json([
            'msg'=>'data was updated',
            'status'=>200
        ],200);
    }
}
