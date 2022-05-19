<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserResponse;
use App\Models\User;
use App\Models\Influncer;
use App\Models\Customer;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ChangePasswordRequest;

class AuthController extends Controller
{
    use UserResponse;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    protected $guard = 'api';

    public function __construct()
    {
     
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['phone', 'password']);

        if ($token = Auth::guard('api')->attempt(['email'=>$request->username,'password'=>$request->password])) {
            // return response()->json(['error' => 'Unauthorized'], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }
        elseif($token = Auth::guard('api')->attempt(['phone'=>$request->username,'password'=>$request->password]))
        {
            
        }
        else
        {
            return response()->json(['error' => 'Unauthorized'], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        $user = Auth::guard('api')->user();
        //dd($user->email);
        if($user->customers)
        {
            if($request->fcm_token){
                $user->update(['fcm_token' => $request->fcm_token]);
            }
			 return response()->json([
                'msg'=>"user data",
				 'data'=>$this->userDataResponse($user,$token , $user->id),
				 'type'=>'customer',
                'status'=>config('global.OK_STATUS') 
            ],config('global.OK_STATUS'));
        }
        if($user->influncers)
        {
            $user->update(['fcm_token' => $request->fcm_token]);
			 return response()->json([
                'msg' => "user data",
				 'data' => $this->userDataResponse($user,$token, $user->id),
				 'type' => 'influencer',
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
         //   return ;
        }
        else
        {
            auth()->guard('api')->logout();
            return response()->json([
                'msg'=>"user dose't have the right role to make this action",
                'status'=>config('global.OK_STATUS') 
            ],config('global.OK_STATUS'));
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token , $user,$type)
    {


        return response()->json([
            'msg'=>'login successfully',
            'data'=>$this->userDataResponse($user,$token, $user->id),
            'type'=>$type == 1?'customer':'Influencer',
            'status'=>200
        ],200);
    }

    public function details($id = null , $type = null)
    {
        
        if($type)
        {
            if($type == 'customer')  $data = Customer::find($id);
            else $data = Influncer::find($id);
           

            if(!$data) return response()->json([
                'err'=>'user not found',
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));

        }
        else
        {
            $data = Auth::guard('api')->user();
            return response()->json([
                'msg'=>'user data',
                'data'=>$this->userDataResponse($data,null,$data->id),
                'type'=>$data->customers?'customer':'Influencer',
                'status'=>config('global.NOT_FOUND_STATUS')
    
            ],200);
        }


        

        return response()->json([
            'msg'=>'user data',
            'data'=>$this->userDataResponse($data->users,null,$data->users->id),
            'type'=>$data->customers?'customer':'Influencer',
            'status'=>config('global.NOT_FOUND_STATUS')

        ],200);
    }

    public function changeLang($lang)
    {
        $supportedLang = config('global.LANGS');
        if(in_array($lang,$supportedLang))
        {
            App::setLocale($lang);
            $user = Auth::guard('api')->user();
            if($user)
            {
                $user = User::find($user->id);
                $user->lang = $lang;
                $user->save();
            }
            
            return response()->json([
                'msg'=>'language was changed',
                'current_lang'=>App::getLocale(),
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }
        return response()->json([
            'msg'=>'language is not supported',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
    }


    public function changePassword(ChangePasswordRequest $request)
    {

        if(Auth::guard('api')->attempt(['email'=>Auth::guard('api')->user()->email,'password'=>$request->password]))
        {
            $data = User::find(Auth::guard('api')->user()->id);
            $data->password = bcrypt($request->new_password);
            $data->save();

            return response()->json([
                'msg'=>'password was changed',
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }
        else
        {
            return response()->json([
                'msg'=>'wrong password',
                'status'=>config('global.WRONG_VALIDATION_STATUS')
            ],config('global.WRONG_VALIDATION_STATUS'));
        }

    }

   
}
