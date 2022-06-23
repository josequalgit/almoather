<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessages;
use Alert;
class ContactMessagesController extends Controller
{
    public function index()
    {
        $data = ContactMessages::orderBy('created_at','desc')->paginate(10);
        return view('dashboard.tickets.index',compact('data'));
    }

    public function delete($id)
    {
        $data = ContactMessages::find($id);
        if(!$data) return response()->json([
            'msg'=>'message was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $data->delete();
        Alert::toast('ticket was deleted', 'success');
        return response()->json([
            'msg'=>'data was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
