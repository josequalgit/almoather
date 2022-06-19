<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacy;

class PrivacyController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
        $data = Privacy::select('text')->find(1);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'privacy_data_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        return response()->json([
            'msg'=>trans($this->trans_dir.'privacy_data_was_found'),
            'data'=>$data->getTranslation('text',app()->getLocale()),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
