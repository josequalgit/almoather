<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacy;

class PrivacyController extends Controller
{
    public function index()
    {
        $data = Privacy::select('text')->find(1);
        if(!$data) return response()->json([
            'err'=>'privacy data not found',
            'status'=>404
        ],404);
        return response()->json([
            'msg'=>'privacy data was found',
            'data'=>$data,
            'status'=>200
        ],200);
    }
}
