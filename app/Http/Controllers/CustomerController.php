<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Auth , Alert;
class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::paginate(10);
        $counter = Customer::count();

        return view('dashboard.customers.index',compact('data','counter'));
    }

    public function edit($id)
    {
        $data = Customer::findOrFail($id);
        return view('dashboard.customers.edit',compact('data'));
    }

    public function updateStatus(Request $request , $id)
    {
        $data = Customer::find($id);
        if(!$data) return response()->json([
            'err'=>'Customer not found',
            'status'=>404
        ],200);
        $data->status = $request->status;
        $data->save();
        activity()->log('Admin "'.Auth::user()->name.'" changed "'. $data->first_name.'  '.$data->last_name.'" Customer status');
        Alert::toast('Customer status was changed', 'success');

        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ]);
    }
}
