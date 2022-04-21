<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;

class MailController extends Controller
{
    public function basic_email(Request $request) {

       

        $user = User::where('email',$request->email)->first();

        if(!$user)
        {
           return response()->json([
               'err'=>'user not found',
               'status'=>404
           ],404);
        }
        $user->code = mt_rand(100000,999999);
        $user->save();
        $data = array('email'=>$request->email,'code'=>$user->code);
     
        Mail::send(['text'=>'mail'], $data, function($message) use($data){
           $message->to($data['email'], 'Test Email')->subject
              ('Laravel Basic Testing Mail');
           $message->from('qusai@josequal.com','Josequal');
        });
       // echo "Basic Email Sent. Check your inbox.";
        return response()->json([
            'msg'=>'Email Sent',
            'status'=>200
        ],200);
     }

     public function checkCode(Request $request)
     {
         $user = User::where('email',$request->email)->first();

         if(!$user)
         {
            return response()->json([
                'err'=>'user not found',
                'status'=>404
            ],404);
         }
         
         if($user->code == $request->code)
         {
            return response()->json([
                'msg'=>'correct code',
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
         }
         else
         {
            return response()->json([
                'msg'=>'wrong code',
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
         }
     }

     public function forgetPassword(Request $request)
     {
        $user = User::where('email',$request->email)->first();

        if(!$user)
        {
           return response()->json([
               'err'=>'user not found',
               'status'=>404
           ],404);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'msg'=>'password was changed',
            'status'=>200
        ],200);
     }



    
}
