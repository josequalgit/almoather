<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InfluncerRequest extends FormRequest
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
            'address'=>'required',
            'bank_name'=>'required',
            'birthday'=>'required|date',
            'id_number'=>'required',
            'bank_account_number'=>'required',
            'bio'=>'required',
            'ads_out_country'=>'required',
            'city_id'=>'required',
            'country_id'=>'required',
            'nationality_id'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation' => 'required',
            'image'=>'required',
            'is_vat'=>'required',
            'ad_price'=>'required',
            'ad_onsite_price'=>'required',
            'categories'=>'required',
            'region_id'=>'required',
            'phone'=>'required',
            'ad_with_vat'=>'required',
            'ad_onsite_price_with_vat'=>'required',
            'social_media'=>'required',
           // 'bank_id'=>'required',
            'snap_chat_views'=>'required',
            'snap_chat_video'=>'required',
            'commercial_registration_no'=>'required',
            'tax_registration_number'=>'required',
            'rep_full_name'=>'required',
            'rep_id_number_name'=>'required',
            'rep_phone_number'=>'required',
            'milestone'=>'required',
            'street'=>'required',
            'neighborhood'=>'required',
            'rep_email'=>'required',
            'tax_registration_number_file'=>'required',
            'commercial_registration_no_file'=>'required',
            
           // 'snap_chat_video'=>'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
        ];
    }

      /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'influncer_category_id.required' => 'Please choose a category',
            'nationality_id.required' => 'Please choose your nationality',
            'country_id.required' => 'Please choose your country',
            'city_id.required' => 'Please choose your city',
            'region_id.required' => 'Please choose your region',
            'bank.required' => 'Please add your bank name',
            'address.required' => 'Please add your address',
            'ads_out_country.required' => 'Please add if you can make ads outside of your country'
        ];
    }

   
	
	
	   /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'err' => $validator->errors()->all()[0],
        'status' => 422
        ], 422));
    }
    }