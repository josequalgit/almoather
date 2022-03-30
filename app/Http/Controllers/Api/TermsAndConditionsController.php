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
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'terms and conditions data was found',
            'data'=>$data->getTranslation('text',app()->getLocale()),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
