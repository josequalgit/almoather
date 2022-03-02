<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
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
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        if($user->customers)
        {
            return $this->respondWithToken($token,$user->customers,1);
        }
        if($user->influncers)
        {
            return $this->respondWithToken($token,$user->influncers,2);
        }
        else
        {
            auth()->guard('api')->logout();
            return response()->json([
                'msg'=>"user dose't have the right role to make this action",
                'status'=>200 
            ],200);
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'user'=>$user,
            'type'=>$type,
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }
}
