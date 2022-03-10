<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;

class TermsAndConditionsController extends Controller
{
    public function index()
    {
        $data = Terms::select('text')->find(1);
        if(!$data) return response()->json([
            'err'=>'terms and conditions data was not found',
            'status'=>404
        ],200);
        return response()->json([
            'msg'=>'terms and conditions data was found',
            'data'=>$data,
            'status'=>200
        ],200);
    }
}
