<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class RegionController extends Controller
{
    private $trans_dir = 'messages.api.';

   public function index($id)
   {
    $data = Country::find($id);
    if(!$data) return response()->json([
        'err'=>trans($this->trans_dir.'country_doset_exist'),
        'status'=>config('global.NOT_FOUND_STATUS')
    ],config('global.NOT_FOUND_STATUS'));

    return response()->json([
        'msg'=>trans($this->trans_dir.'all_regions_belongs_to').' '.$data->name,
        'data'=>$data->regions()->select(['id','name'])->get(),
        'status'=>config('global.OK_STATUS')
    ],config('global.OK_STATUS'));
   }
}
