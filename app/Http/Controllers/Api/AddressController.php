<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
 
class AddressController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
        $data = Address::select(['id','name'])->get();
        return response()->json([
            'msg'=>trans($this->trans_dir.'all_address_available'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
