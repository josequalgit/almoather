<?php
trait SendNotification {
    function sendNotifications($tokens,$data,$topic = false){
        $apiKey = "AAAANfr15q4:APA91bFO9lO-XRcSI1lgJVdT2taopCIE27kHWp6k0--nQLCyAmIOXhX5RupGsZTnIC1CwMrRBcyFzvc6ZIqWgenj4aFsUgkUm6q_jyt9JVgJfnP16vfqzuZCMg8BD-b2BiyMqY8LpTZd";

        $url = 'https://android.googleapis.com/gcm/send';

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

        // Execute post
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === FALSE) {
            Log::error('Curl failed: ' . curl_error($ch));
        }
        
        
    }
}