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
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'nick_name'=>'required',
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
            'dial_code'=>'required',
            'phone'=>'required|unique:users',
            'ad_with_vat'=>'required',
            'ad_onsite_price_with_vat'=>'required',
            'social_media'=>'required',
            'bank_id'=>'required',
            'commercial_registration_no'=>'required',
            'bank_account_name'=>'required',
            'rep_city'=>'required',
            'rep_area'=>'required',
            'milestone'=>'required',
            'street'=>'required',
            'neighborhood'=>'required',
            'rep_full_name'=>'required',
            'cr_file'=>'required',
            'country_code'=>'required',
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
            'ads_out_country.required' => 'Please add if you can make ads outside of your country',
            'first_name.required' => 'Please add your first name',
            'last_name.required' => 'Please add your last name',
            'nick_name.required' => 'Please add your nick name',
            'id_number.required' => 'Please add your id number',
            'bank_account_number.required' => 'Please add your bank account number',
            'bio.required' => 'Please add your bio',
            'city_id.required' => 'Please add the city',
            'country_id.required' => 'Please add the country',
            'nationality_id.required' => 'Please add the nationality id',
            'email.required' => 'Please add the email',
            'password.required' => 'Please add the password',
            'password_confirmation.required' => 'Please add the confirm password',
            'image.required' => 'Please add the image',
            'is_vat.required' => 'Please add the vat',
            'ad_price.required' => 'Please add the online ad price',
            'ad_onsite_price.required' => 'Please add the onsite ad price',
            'categories.required' => 'Please add the categories',
            'region_id.required' => 'Please add the region',
            'dial_code.required' => 'Please add the dial code',
            'phone.required' => 'Please add the phone number',
            'ad_with_vat.required' => 'Please add the ad with vat price',
            'ad_onsite_price_with_vat.required' => 'Please add the ad with vat onsite price',
            'social_media.required' => 'Please add the social_media',
            'bank_id.required' => 'Please add the bank',
            'commercial_registration_no.required' => 'Please add commercial registration number',
            'bank_account_name.required' => 'Please add the bank account name',
            'rep_city.required' => 'Please add the represent city name',
            'rep_area.required' => 'Please add the represent area name',
            'milestone.required' => 'Please add some milestone near you',
            'street.required' => 'Please add the street',
            'middle_name.required' => 'Please add middle name',
            'neighborhood.required' => 'Please add the neighborhood',
            'cr_file.required' => 'Please add the cr file',
            'country_code.required' => 'Please add the country code',
            'email.unique' => 'Email should be unique',
            'phone.unique' => 'Phone should be unique',


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
