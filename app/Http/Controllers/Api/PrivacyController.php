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
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>'privacy data was found',
            'data'=>$data->getTranslation('text',app()->getLocale()),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
