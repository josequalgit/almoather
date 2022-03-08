<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
 
class AddressController extends Controller
{
    public function index()
    {
        $data = Address::select(['id','name'])->get();
        return response()->json([
            'msg'=>'all address available',
            'data'=>$data,
            'status'=>200
        ],200);
    }
}
