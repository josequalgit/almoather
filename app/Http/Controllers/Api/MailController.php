<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function basic_email(Request $request) {
        $data = array('email'=>$request->email);
     
        Mail::send(['text'=>'mail'], $data, function($message) use($data){
           $message->to($data['email'], 'Test Email')->subject
              ('Laravel Basic Testing Mail');
           $message->from('qusai@josequal.com','Josequal');
        });
        echo "Basic Email Sent. Check your inbox.";
     }

    
}
