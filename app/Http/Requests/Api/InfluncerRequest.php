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
            'bank_name'=>'required',
            'bank_account_number'=>'required',
            'bio'=>'required',
            'ads_out_country'=>'required',
            'city_id'=>'required',
            'country_id'=>'required',
            'nationality_id'=>'required',
            'email'=>'required|unique:users',
            'name'=>'required',
            'password'=>'required',
            'image'=>'required',
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
        'errors' => $validator->errors(),
        'status' => true
        ], 422));
    }
    }
