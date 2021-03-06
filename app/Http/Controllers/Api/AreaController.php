<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class AreaController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index($id)
    {
        $data = Country::find($id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'city_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $regions = $data->regions()->get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'areas_for').$data->name.' '.trans($this->trans_dir.'country_small'),
            'data'=>$regions,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
