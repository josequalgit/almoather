<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Requests\BankRequest;
use Alert;
class BankController extends Controller
{
    public function index()
    {
        $data = Bank::orderBy('created_at','desc')->paginate(10);
        return view('dashboard.banks.index',compact('data'));
    }

    public function store(BankRequest $request)
    {
        $merge_data = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en
        ]]);


        Bank::create($merge_data);
        Alert::toast('Bank was created', 'success');
        return response()->json([
            'msg'=>'data was created',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function update(BankRequest $request,$id)
    {
        $data = Bank::find($id);

        if(!$data) return response()->json([
            'msg'=>'data was not found',
            'statis'=>config('global.NOT_FOUND_STATU'),
        ],config('global.NOT_FOUND_STATU'));

        $merge_data = array_merge($request->all(),['name'=>[
            'ar'=>$request->name_ar,
            'en'=>$request->name_en
        ]]);
        $data->update($merge_data);

        Alert::toast('Bank was created', 'success');
        return response()->json([
            'msg'=>'data was created',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function delete($id)
    {
        Bank::destroy($id);
        return response()->json([
            'msg'=>'data was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }
}
