<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Auth , Alert;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::with('users')->paginate(10);
        $counter = Customer::with('users')->count();


        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $year = Carbon::now()->year;
        $influncersData = [];

        foreach($months as $month)
        {
            $influncerNumber = Customer::whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();
            array_push($influncersData,$influncerNumber);
        }


        return view('dashboard.customers.index',compact('data','counter','influncersData'));
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

    public function show_ads($id)
    {
        $customer = Customer::findOrFail($id);
        $data = $customer->ads()->paginate(10);
        $counter = $customer->ads()->count();
        $ads = $customer->ads()->get()->take(5);

        return view('dashboard.customers.showAds',compact('data' , 'counter' , 'customer','ads'));
    }
}
