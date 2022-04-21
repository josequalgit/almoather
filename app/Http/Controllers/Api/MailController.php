<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function basic_email(Request $request) {
        $data = array('name'=>"Virat Gandhi");
     
        Mail::send(['text'=>'mail'], $data, function($message) {
           $message->to($request->email, 'Test Email')->subject
              ('Laravel Basic Testing Mail');
           $message->from('qusai@josequal.com','Josequal');
        });
        echo "Basic Email Sent. Check your inbox.";
     }

    
}
