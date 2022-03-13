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


        /// Customer
        if($type == 1)
        {
            $userData = [
                'id'=>$user->id,
                'first_name'=> $user->customers->first_name,
                'last_name'=>$registeredUserData->last_name,
                'phone'=>$registeredUserData->phone,
                'nationality'=>$registeredUserData->nationalities->id,
                'id_number'=>$registeredUserData->id_number,
                'country'=>[
                    'id'=>$registeredUserData->countrys->id,
                    'name'=>$registeredUserData->countrys->name
                ],
                 'region'=>[
                    'id'=>$registeredUserData->regions->id,
                    'name'=>$registeredUserData->regions->name
                ],
                 'city'=>[
                    'id'=>$registeredUserData->citys->id,
                    'name'=>$registeredUserData->citys->name
                ],
                'nationality'=>[
                    'id'=>$registeredUserData->nationalities->id,
                    'name'=>$registeredUserData->nationalities->name
                ],
                'token'=>$token
            ];
        }
        else
        {
            $userData = [
                'id'=>$registeredUserData->id,
                'full_name_en' =>$registeredUserData->full_name_en,
                'full_name_ar'=>$registeredUserData->full_name_ar,
                'image'=>$user->infulncerImage,
                'nick_name'=>$registeredUserData->nick_name,
                'nationality_id'=>$registeredUserData->nationality_id,
                'country_id'=>$registeredUserData->country_id,
                'region_id'=>$registeredUserData->region_id,
                'city_id'=>$registeredUserData->city_id,
                'influencer_category'=>$registeredUserData->InfluncerCategories()->get()->map(function($item){
                    return[
                        'id'=>$item->id,
                        'name'=>$item->name
                    ];
                }),
                'bio'=>$registeredUserData->bio,
                'address_id'=>$registeredUserData->address_id,
                'ad_price'=>$registeredUserData->ad_price,
                'ad_onsite_price'=>$registeredUserData->ad_onsite_price,
                'bank_id'=>$registeredUserData->banks->id,
                'bank_account_number'=>$registeredUserData->bank_account_number,
                'email'=>$user->email,
                'phone'=>$registeredUserData->phone,
                'id_number'=>$registeredUserData->id_number,
                'status'=>$registeredUserData->status,
                'is_vat'=>$registeredUserData->is_vat,
                'birthday'=>$registeredUserData->birthday,
                'ads_out_country'=>$registeredUserData->ads_out_country,
                'ad_with_vat'=>$registeredUserData->ad_with_vat,
                'ad_onsite_price_with_vat'=>$registeredUserData->ad_onsite_price_with_vat,
                'token'=>$token
            ];


        }

        return response()->json([
            'msg'=>'login successfully',
            'data'=>$userData,
            'type'=>$type == 1?'customer':'Influencer',
            'status'=>200
        ],200);
    }
}
