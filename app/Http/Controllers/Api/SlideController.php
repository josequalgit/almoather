<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
{
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
            'msg'=>'all status',
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
         
    }
}
