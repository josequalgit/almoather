<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    public function index($user_id,$type)
    {
        $user = User::find($user_id);
        $data = Message::where([['receiver_id',$user_id],['type',$type]])
        ->orWhere([['sender_id',$user_id],['type',$type,'updated_at']])->get()->map(function($item){
            return [
                'message'=>$item->text,
                'sender_id'=>$item->sender_id,
                'receiver_id'=>$item->receiver_id,
                'date'=>$item->created_at->format('Y-m-d')
            ];
        });
       

        return response()->json([
            'data'=>$data,
            'status'=>config('global.OK_STATUS'),
            'msg'=>'data was return'
        ],config('global.OK_STATUS'));
    }
}
