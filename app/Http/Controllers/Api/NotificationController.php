<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Auth;

class NotificationController extends Controller
{
    public function index($type = null)
    {
        $user = Auth::guard('api')->user();
        $data = [];
        if(!$user) return response()->json([
            'msg'=>'user is not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        if($type == 'read')
        {
            $data = $user->notifications()->select(['data','id'])->paginate(config('global.PAGINATION_NUMBER'));
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
            $data = $user->unreadNotifications()->select('data')->paginate(config('global.PAGINATION_NUMBER'));
        }
        return response()->json([
            'msg'=>'user notification',
            'data'=>$data,
            'type'=>$type,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
