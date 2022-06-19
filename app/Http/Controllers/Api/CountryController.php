<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
        $data = Country::get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code
            ];
        });
        return response()->json([
            'msg'=>trans($this->trans_dir.'all_the_countries_available'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
