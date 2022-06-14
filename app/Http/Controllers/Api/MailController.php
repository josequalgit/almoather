<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\CheckCodeRequest;
use App\Http\Requests\Api\SendEmailRequest;
use Mail;

class MailController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function basic_email(SendEmailRequest $request) {

        $user = User::where('email',$request->email)->first();

        if(!$user)
        {
           return response()->json([
               'err'=>trans($this->trans_dir.'user_not_found'),
               'status'=>404
           ],404);
        }
        $user->code = mt_rand(100000,999999);
        $user->save();
        $data = array('email'=>$request->email,'code'=>$user->code);
     
        Mail::send(['text'=>'mail'], $data, function($message) use($data){
           $message->to($data['email'], 'Test Email')->subject
              ('Password Reset');
           $message->from('qusai@josequal.com','Josequal');
        });
       // echo "Basic Email Sent. Check your inbox.";
        return response()->json([
            'msg'=>trans($this->trans_dir.'email_sent'),
            'status'=>200
        ],200);
     }

     public function checkCode(CheckCodeRequest $request)
     {
         $user = User::where('email',$request->email)->first();

         if(!$user)
         {
            return response()->json([
                'err'=>trans($this->trans_dir.'user_not_found'),
                'status'=>404
            ],404);
         }
         
         if($user->code == $request->code)
         {
            return response()->json([
                'msg'=>trans($this->trans_dir.'correct_code'),
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
         }
         else
         {
            return response()->json([
                'err'=>trans($this->trans_dir.'wrong_code'),
                'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
            ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
         }
     }

     public function forgetPassword(ForgetPasswordRequest $request)
     {
        $user = User::where('email',$request->email)->first();

        if(!$user)
        {
           return response()->json([
               'err'=>trans($this->trans_dir.'user_not_found'),
               'status'=>404
           ],404);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'msg'=>trans($this->trans_dir.'password_was_changed'),
            'status'=>200
        ],200);
     }



    
}
