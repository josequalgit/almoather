<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Http\Requests\NotificationRequest;
use App\Models\User;
use App\Models\Ad;
use DB;
use Auth;
use Alert;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        
        // $data = DB::table('notifications')->orderBy('created_at','desc')->paginate(10);
        // $result = $data->getCollection()->transform(function($item, $key) {
        //     $obj = json_decode($item->data);
        //     return [
        //         'msg' => $obj->msg,
        //     ];
        // });    
        $data = Auth::user()->notifications()->paginate(10);
        return view('dashboard.notifiactions.index',compact('data'));
    }


    public function create()
    {
        $data = User::get();
        return view('dashboard.notifiactions.create',compact('data'));
    }


    public function store(NotificationRequest $request)
    {
        $info =[
            'msg'=>$request->message,
            'type'=>'User',
            'id'=>0
        ];
        if($request->users == 'all')
        {
            $users = User::get();
            Notification::send($users, new AddInfluencer($info));
            activity()->log('Admin "'.Auth::user()->name.'" sent a notification to all users');
        }
        else
        {
            $sendTo = User::find($request->users);
            $sendTo->notify(new AddInfluencer($info));
            activity()->log('Admin "'.Auth::user()->name.'" sent a notification to '.$sendTo->name);


        }

        Alert::toast('Notification was sent', 'success');
        return redirect()->route('dashboard.notifications.index');
    }

    public function read($id)
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
                Alert::toast('Notification was not found', 'error');
                return back();
            }
            else
            {
                return redirect()->route('dashboard.ads.edit',$ad->id);
            }

        }
        else
        {
            $user = User::find($notificationData->id);
            if(!$user)
            {
                Alert::toast('User was not found', 'error');
                return back();
            }
            else
            {
                if($user->influncers)
                {
                    return redirect()->route('dashboard.influncers.edit',$user->influncers->id);
                }
                else
                {
                    return redirect()->route('dashboard.customers.edit',$user->customers->id);
                }
            }
        }
    }


    private function createNotificationForTesting($user_id = null , $msg = null)
    {
        $info =[
            'msg'=>'This mail just for testing',
        ];
        if(!$user_id)
        {
            $users = User::get();
            Notification::send($users, new AddInfluencer($msg ? $msg : $info));
        }
        else
        {
            $sendTo = User::find($user_id);
            $sendTo->notify(new AddInfluencer($msg ? $msg : $info));
        }
    }
}
