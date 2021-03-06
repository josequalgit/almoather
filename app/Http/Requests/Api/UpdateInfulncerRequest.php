<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateInfulncerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name_en'=>'required',
            'full_name_ar'=>'required',
            'nick_name'=>'required',
            'bank_name'=>'required',
            'birthday'=>'required|date',
            'id_number'=>'required',
            'bank_account_number'=>'required',
            'bio'=>'required',
            'ads_out_country'=>'required',
            'city_id'=>'required',
            'country_id'=>'required',
            'nationality_id'=>'required',
            'email'=>'',
            'password'=>'',
            'password_confirmation' => '',
            'image'=>'',
            'is_vat'=>'required',
            'ad_price'=>'required',
            'ad_onsite_price'=>'required',
            'categories'=>'required',
            'region_id'=>'required',
            'phone'=>'required|unique:users,phone,' . Auth::guard('api')->user()->id,
            'ad_with_vat'=>'required',
            'ad_onsite_price_with_vat'=>'required',
            'social_media'=>'required',
            'bank_id'=>'required',
            'snap_chat_views'=>'',
            'snap_chat_video'=>'',
            'milestone'=>'required',
            'street'=>'required',
            'neighborhood'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'influncer_category_id.required' => 'Please choose a category',
            'nationality_id.required' => 'Please choose your nationality',
            'country_id.required' => 'Please choose your country',
            'city_id.required' => 'Please choose your city',
            'region_id.required' => 'Please choose your region',
            'bank_id.required' => 'Please choose your bank',
            'address_id.required' => 'Please choose your address',
            'ads_out_country.required' => 'Please add if you can make ads outside of your country'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'err' => $validator->errors()->all()[0],
        'status' => 422
        ], 422));
    }
}
