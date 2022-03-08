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
            return $this->respondWithToken($token,$user,1);
        }
        if($user->influncers)
        {
            return $this->respondWithToken($token,$user,2);
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
        $registeredUserData = $user->customers ?? $user->influncers;
        $userData = null;

        if($type == 1)
        {
            $userData = [
                'id'=>$user->id,
                'email'=>$user->email,
                'first_name'=>$registeredUserData->first_name,
                'last_name'=>$registeredUserData->last_name,
                'phone'=>$registeredUserData->phone,
                'status'=>$registeredUserData->status
            ];
        }
        else
        {
            $userData = [
                'id'=>$user->id,
                'name'=>$registeredUserData->full_name_en,
                'nick_name'=>$registeredUserData->nick_name,
                'bank_name'=>$registeredUserData->bank_name,
                'bank_account_number'=>$registeredUserData->bank_account_number,
                'bio'=>$registeredUserData->bio,
                'ads_out_country'=>$registeredUserData->ads_out_country,
                'status'=>$registeredUserData->ads_out_country,
                'is_vat'=>$registeredUserData->is_vat,
                'ad_price'=>$registeredUserData->ad_price,
                'ad_onsite_price'=>$registeredUserData->ad_onsite_price,
                'city'=>[
                    'id'=>$registeredUserData->citys->id,
                    'name'=>$registeredUserData->citys->name
                ],
                'country'=>[
                    'id'=>$registeredUserData->countries->id,
                    'name'=>$registeredUserData->countries->name
                ],
                'nationality'=>[
                    'id'=>$registeredUserData->nationalities->id,
                    'name'=>$registeredUserData->nationalities->name
                ],
                'influencer_category'=>[
                    'id'=>$registeredUserData->nationalities->id,
                    'name'=>$registeredUserData->nationalities->name
                ],
            ];
        }

        return response()->json([
            'access_token' => $token,
            // 'token_type' => 'bearer',
            'user'=>$userData,
            'type'=>$type == 1?'customer':'Influencer',
            // 'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }
}
