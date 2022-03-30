<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\AddInfluencer;
use App\Http\Requests\NotificationRequest;
use DB;
use Auth;
use Alert;

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
