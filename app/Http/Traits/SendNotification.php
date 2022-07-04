<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Notification;

trait SendNotification {
    function sendNotifications($tokens,$data,$topic = false){
        $apiKey = "AAAANfr15q4:APA91bFO9lO-XRcSI1lgJVdT2taopCIE27kHWp6k0--nQLCyAmIOXhX5RupGsZTnIC1CwMrRBcyFzvc6ZIqWgenj4aFsUgkUm6q_jyt9JVgJfnP16vfqzuZCMg8BD-b2BiyMqY8LpTZd";

        $url = 'https://fcm.googleapis.com/fcm/send';

        $data['sound'] = 'default';
        $data['icon'] = 'ic_launcher';

        $fields = array(
            'notification' => $data,
            'data' => $data
        );

        if($topic){
            $fields['topic'] = $topic;
        }else{
            $fields['registration_ids'] = $tokens;
        }
        
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the URL, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Execute post
        $result = curl_exec($ch);
        curl_close($ch);
        if ($httpcode != 200) {
			Log::error('result fcm: ' . $result);
            Log::error('Curl failed: ' . curl_error($ch));
        }
        
        
    }
    function sendAdminNotification($channel,$data)
    {
        $data = (object) $data;
        $ad = null;
        if($data->id == null || $data->msg == null) throw new \Exception('Error Adding Data To Admin Notification function. Please Check The Data object');
        if($data->type == 'ad')
        {
            $ad = Ad::find($data->id);
            Notification::send([$ad->customers->users], new AddInfluencer($info));
        }


        Redis::publish($channel, json_encode([
            'id'=> $data->id,
            "message" => trans($data->msg,['ad_name'=>$ad?$ad->name:'']),
            "date" => Carbon::now()->diffForHumans(),
        ]));
    }
}
