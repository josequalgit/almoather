<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Ad;
use Carbon\Carbon;
use Auth , DB;

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

        $data = $user->notifications()->select(['data','id'])->paginate(config('global.PAGINATION_NUMBER'));
           $data->getCollection()->transform(function($item){
            if(array_key_exists('msg', $item->data))
            {
                return [
                    'id'=>$item->id,
                    'msg'=>$item->data['msg'],
                    'data_id'=>$item->data['id']?$item->data['id']:null,
                    'type'=>$item->data['type'],
                    'read'=>$item->read_at?true:false
                ];
            }
            });
        return response()->json([
            'msg'=>'user notification',
            'data'=>$data,
            'type'=>$type,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function readNotification($id)
    {
  
        $data = DB::table('notifications')->where('id',$id)->first();

        if(!$data)  return response()->json([
             'err'=>'wrong notification id',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $UpdateData = DB::table('notifications')->where('id',$id)->update([
            'read_at'=>Carbon::now()
        ]);

        $notificationData = json_decode($data->data);
        if($notificationData->type == 'Ad')
        {

            $ad = Ad::find($notificationData->id);
            if(!$ad)
            {
                return response()->json([
                    'err'=>'the ad was not found',
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }
            else
            {
                $data->read_at = Carbon::now();
                // $data->update([
                //     'read_at'=>Carbon::now()
                // ]);
                return response()->json([
                    'msg'=>'data was found',
                    'type'=>'Ad',
                    'id'=>$ad->id
                ],config('global.OK_STATUS'));
            }

        }
        else
        {
            $user = User::find($notificationData->id);

            if(!$user)
            {
                return response()->json([
                    'err'=>'user was not found',
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }
            else
            {
                if($user->influncers)
                {
                   
                    return response()->json([
                        'msg'=>'data was found',
                       'data'=>[
                        'type'=>'Influencers',
                        'id'=>$user->influncers->id,
                       ],
                        'status'=>config('global.OK_STATUS')
                    ],config('global.OK_STATUS'));
                }
                else
                {
                   
                    return response()->json([
                        'msg'=>'data was found',
                        'data'=>[
                            'type'=>'Customer',
                        'id'=>$user->customers->id,
                        ],
                        'status'=>config('global.OK_STATUS')
                    ],config('global.OK_STATUS'));
                }
            }
        }
    }
}
