<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Message;
use App\Models\User;
use Auth;
class ChatController extends Controller
{
    public function index()
    {        
        
        $usersMessages = Message::where('type','support')->groupBy('sender_id')->pluck('sender_id');
        $usersMessagesTo = Message::where('type','support')->groupBy('receiver_id')->pluck('receiver_id');
        $userMessages = $usersMessages->merge($usersMessagesTo);
        // dd($userMessages);

        $users = User::whereIn('id',$userMessages)->where(function($query){
            $query->whereHas('customers')
            ->OrWhereHas('influncers');
        })->get()->map(function($item){
          
           

            return $item;
            
               
        
            
        });

        // REMOVE THE DUPLICATED USERS FROM THE ARRAY
        // $users =  $this->remove_duplicated_objects_in_array($usersMessages->toArray());

        // dd($users);
       
        return view('dashboard.chat.index',compact('users'));
    }

    
    private function remove_duplicated_objects_in_array($array)
    {
        foreach ($array as $key => $value) {
           foreach ($array as $key2 => $value2) {
                if(array_key_exists($key,$array)&&$key !== $key2&&$array[$key]->id == $array[$key2]->id) unset($array[$key2]);


           }
        }

        return $array;
    }

    public function get_messages($user_id)
    {
        $user = User::find($user_id);
        $data = Message::where([['receiver_id',$user_id],['type','support']])
        ->orWhere([['sender_id',$user_id],['type','support','updated_at']])->get()->map(function($item){
            return [
                'text'=>$item->text,
                'sender_id'=>$item->sender_id,
                'receiver_id'=>$item->receiver_id,
                'time'=>$item->created_at->format('Y-m-d')
            ];
        });
        $inf = $user->influncers??$user->customers;

        $userData = (object)[];
        if($inf == null)
        {
            $userData->name = 'Support';
        }
        else
        {
            $userData->name = $inf->first_name.' '.$inf->middle_name.' '.$inf->last_name;
        }
        if($user->influncers)
        {
            $userData->image = $user->infulncerImage['url'];
            $userData->type = 'influencer';
            $userData->email = $user->email;
            $userData->phone = $user->phone;
            $userData->time = $user->phone;
        }
        else
        {
            $userData->image = $user->image['url'];
            $userData->type = 'customer';
            $userData->email = $user->email;
            $userData->phone = $user->phone;
        }

        return response()->json([
            'data'=>[
                'user'=>$userData,
                'messages'=>$data
            ],
            'status'=>config('global.OK_STATUS'),
            'msg'=>'data was return'
        ],config('global.OK_STATUS'));
    }

    public function sendMessage(Request $request)
    {
     
       $message =  Message::create([
            'sender_id'=>Auth::user()->id,
            'receiver_id'=>$request->receiver_id,
            'text'=>$request->messages,
            'type'=>'support'
        ]);

     
        Redis::publish('message.user-5', json_encode([
            "message" => $request->messages,
            "date" => $message->created_at->format('d/m/Y h:i'),
            'sender_id' => Auth::user()->id,
            'receiver_id'=> $request->receiver_id,
        ]));

        return response()->json([
            'msg'=>'msg was created',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    
    }

    public function sendMessageTo(Request $request)
    {
        Redis::publish('message.user-5', json_encode([
            "message" => "hello",
            "date" => '23/05/2022 04:25',
            'sender_id' => 5,
            'receiver_id'=> Auth::user()->id,
        ]));
    }
}
