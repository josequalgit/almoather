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
            return $this->userDataResponse($user,$token);
        }
        if($user->influncers)
        {

            return $this->userDataResponse($user,$token);
            // return $this->respondWithToken($token,$user,2);
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

        $registeredUserData = $user->customers ?? $user->influncers;


        $userData = null;


        /// Customer
        if($type == 1)
        {
            $userData = [
                'id'=>$user->id,
                'image'=>$user->image,
                'image'=>$user->email,
                'first_name'=> $user->customers->first_name,
                'last_name'=>$registeredUserData->last_name,
                'phone'=>$registeredUserData->phone,
                'id_number'=>$registeredUserData->id_number,
                'country_id'=>$registeredUserData->countrys->id,
                 'region_id'=>$registeredUserData->regions->id,
                 'city_id'=>$registeredUserData->citys->id,
                'nationality_id'=>$registeredUserData->nationalities->id,
                'status'=>$registeredUserData->status,
                'verify'=>$registeredUserData->email_verified_at ? true : false,
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

    public function details()
    {
        $data = Auth::guard('api')->user();
        return response()->json([
            'msg'=>'user data',
            'data'=>$this->userDataResponse($data),
            'status'=>config('global.OK_STATUS')

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
