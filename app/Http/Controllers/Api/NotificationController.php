<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Ad;
use Carbon\Carbon;
use Auth , DB , App;

class NotificationController extends Controller
{
    private $trans_dir = 'notifications.';

    public function index($type = null)
    {
        $user = Auth::guard('api')->user();
        $data = [];

        if(!$user) return response()->json([
            'msg'=>trans($this->trans_dir.'user_was_not_found'),
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
    


        $data = $user->notifications()->select(['data','id'])->paginate(config('global.PAGINATION_NUMBER'));

        $data->getCollection()->transform(function($item){
            $title = $item->data['title'] ?? $item->data['msg'];
            $params = $item->data['params'] ?? [];
            $msg = trans($this->trans_dir.$item->data['msg'],$params);
            $title = trans($this->trans_dir.$title,$params);
            

            return [
                'id'        => $item->id,
                'title'     => $title,
                'msg'       => $msg,
                'text'      => $msg,
                'data_id'   => $item->data['id'] ? $item->data['id'] : null,
                'type'      => $item->data['type'],
                'read'      => $item->read_at ? true : false
            ];
            
        });
        return response()->json([
            'msg'       => trans($this->trans_dir.'user_notification'),
            'data'      => $data,
            'type'      => $type,
            'status'    => config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function readNotification($id)
    {
  
        $data = DB::table('notifications')->where('id',$id)->first();
     
        
        if(!$data)  return response()->json([
             'err'=>trans($this->trans_dir.'wrong_notification_id'),
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
                    'err'=>trans($this->trans_dir.'ad_not_found'),
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }
            else
            {
               
                return response()->json([
                    'msg'=>trans($this->trans_dir.'data_not_found'),
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
                    'err'=>trans($this->trans_dir.'user_not_found'),
                    'status'=>config('global.NOT_FOUND_STATUS')
                ],config('global.NOT_FOUND_STATUS'));
            }
            else
            {
                if($user->influncers)
                {
                   
                    return response()->json([
                        'msg'=>trans($this->trans_dir.'data_was_found'),
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
                        'msg'=>trans($this->trans_dir.'data_was_found'),
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
