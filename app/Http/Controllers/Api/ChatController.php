<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Influncer;
use App\Models\Customer;
use Auth;
use App\Http\Traits\UploadFiles;
use App\Http\Requests\Api\UploadFileRequest;
class ChatController extends Controller
{
    use UploadFiles;
    
    public function index($user_id,$type)
    {
        if($type == 'app')
        {
            $userData = Auth::guard('api')->user();
            $sender_id = $userData->id;

            if(!$userData->influncers)
            {
                $user = Influncer::find($user_id);
                $channel = 'user-'.$userData->id .'-'. $user->users->id;
            }
            else
            {
                $user = Customer::find($user_id);
                $channel = 'user-'. $user->users->id.'-'.$userData->id;
            }
            $receiver_id = $user->users->id;
            $data = Message::where([['receiver_id',$user->users->id],['sender_id',$userData->id],['type',$type]])
            ->orWhere([['receiver_id',$userData->id],['sender_id',$user->users->id],['type',$type]])->get()->map(function($item){
                return [
                    'message'=>$item->text,
                    'sender_id'=>$item->sender_id,
                    'receiver_id'=>$item->receiver_id,
                    'date'=>$item->created_at->format('Y-m-d')
                ];
            });
        }
        else
        {
            //$user = Auth::guard('api')->user()->influncers;
            $receiver_id = Auth::guard('api')->user()->influncers?Auth::guard('api')->user()->influncers->users->id:Auth::guard('api')->user()->customers->users->id;
            $data = Message::where([['receiver_id',Auth::guard('api')->user()->id],['type',$type]])
            ->orWhere([['sender_id',Auth::guard('api')->user()->id],['type',$type,'updated_at']])->get()->map(function($item){
                return [
                    'message'=>$item->text,
                    'sender_id'=>$item->sender_id,
                    'receiver_id'=>$item->receiver_id,
                    'date'=>$item->created_at->format('Y-m-d')
                ];
            });
        }
       
        $response = [
            'data'=>$data,
            'status'=>config('global.OK_STATUS'),
            'msg'=>'data was return',
            'receiver_id'=>1,
            'sender_id'=>$receiver_id,
        ];
        if($type == 'app')
        {
            $response['channel'] = $channel;

            // $response['influencer_id'] = (int) $user_id;
        }

        return response()->json($response,config('global.OK_STATUS'));
    }

    public function uploadFiles(UploadFileRequest $request)
    {
       
        $file = $this->uploadFile('chat_files',$request->file('file'));
        return response()->json([
            'status'=>config('global.OK_STATUS'),
            'data'=>$file,
        ],config('global.OK_STATUS'));
    }
}
