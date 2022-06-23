<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Region;


class CityController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index($id)
    {
        $data = Region::find($id);
        if(!$data) return response()->json([
            'err'=>trans($this->trans_dir.'area_doset_exist'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $cities = $data->cities()->get()->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'all_cities_belongs_to').' '.$data->name,
            'data'=>$data->cities()->get()->map(function($item){
                return [
                    'id'=>$item->id,
                    'name'=>$item->name,
                ];
            }),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
