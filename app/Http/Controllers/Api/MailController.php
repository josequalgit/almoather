<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\CheckCodeRequest;
use App\Http\Requests\Api\SendEmailRequest;
use Mail;
use Carbon\Carbon;

class MailController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function basic_email(SendEmailRequest $request) {

        $user = User::where('email',$request->email)->first();

        if(!$user)
        {
           return response()->json([
               'err'=>trans($this->trans_dir.'user_not_found'),
               'status'=>config('global.NOT_FOUND_STATUS')
           ],config('global.NOT_FOUND_STATUS'));
        }
        $user->code = rand(100000,999999);
        $user->save();
        $data = array('email'=>$request->email,'code'=>$user->code);
     
@Mail::send(['text'=>'mail'], $data, function($message) use($data){
           $message->to($data['email'], 'Reset Password')->subject
              ('Reset Password');
           $message->from('info@almuaathir.com','Almuaathir');
        });
       // echo "Basic Email Sent. Check your inbox.";
        return response()->json([
            'msg'=>trans($this->trans_dir.'email_sent'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
     }

     public function checkCodeWeb(Request $request)
     {
         $user = User::where('code',$request->code)->first();

         if($user)
         {
            $user->update(['email_verified_at'=>Carbon::now()]);
            return response()->json([
                'msg'=>trans($this->trans_dir.'correct_code'),
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
         }
         else
         {
             
            return response()->json([
                'err'=>trans($this->trans_dir.'wrong_code'),
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
         }
     }
     public function checkCode(CheckCodeRequest $request)
     {
         $user = User::where('email',$request->email)->first();

         if(!$user)
         {
            return response()->json([
                'err'=>trans($this->trans_dir.'user_not_found'),
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));
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
               'status'=>config('global.NOT_FOUND_STATUS')
           ],config('global.NOT_FOUND_STATUS'));
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'msg'=>trans($this->trans_dir.'password_was_changed'),
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
     }



    
}
