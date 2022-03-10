<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\User;


class NotificationController extends Controller
{
    public function index($id , $type = null)
    {
        $user = User::find($id);
        $data = [];
        if(!$user) return response()->json([
            'msg'=>'user is not found',
            'status'=>404
        ],404);
        if($type == 'read')
        {
            $data = $user->notifications()->select(['data','id'])->paginate(10);
           $data->getCollection()->transform(function($item){
            if(array_key_exists('msg', $item->data))
            {
                return [
                    'id'=>$item->id,
                    'msg'=>$item->data['msg'],
                ];
            }
            });
        }
        else
        {
            $data = $user->unreadNotifications()->select('data')->paginate(10);
        }
        return response()->json([
            'msg'=>'user notification',
            'data'=>$data,
            'type'=>$type
        ]);
    }
}
