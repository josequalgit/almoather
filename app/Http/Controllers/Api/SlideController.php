<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\slide;

class SlideController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
        $data = Slide::get()->map(function($item){
            return[
                'title'=>$item->title,
                'description'=>$item->description,
                'image'=>$item->image
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_status'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
         
    }
}
