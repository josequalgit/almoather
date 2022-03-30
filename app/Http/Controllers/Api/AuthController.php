<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserResponse;
use App;
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
      // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        $user = Auth::guard('api')->user();

        if($user->customers)
        {
            // return $this->respondWithToken($token,$user,1);
			 return response()->json([
                'msg'=>"user data",
				 'data'=>$this->userDataResponse($user,$token),
				 'type'=>'customer',
                'status'=>config('global.OK_STATUS') 
            ],config('global.OK_STATUS'));
        }
        if($user->influncers)
        {
			 return response()->json([
                'msg'=>"user data",
				 'data'=>$this->userDataResponse($user,$token),
				 'type'=>'influencer',
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
            'data'=>$this->userDataResponse($user,$token),
            'type'=>$type == 1?'customer':'Influencer',
            'status'=>200
        ],200);
    }

    public function details()
    {
        $data = Auth::guard('api')->user();
        return response()->json([
            'msg'=>'user data',
            'data'=>$this->userDataResponse($data),
            'status'=>config('global.NOT_FOUND_STATUS')

        ],200);
    }

    public function changeLang($lang)
    {
        $supportedLang = config('global.LANGS');
        if(in_array($lang,$supportedLang))
        {
            App::setLocale($lang);
            
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
}
