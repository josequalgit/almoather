<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRequest extends FormRequest
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
            'gender'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation' => 'required',
            'country_id'=>'required',
            'country_code'=>'required',
            'dial_code'=>'required',
            'region_id'=>'required',
            'nationality_id'=>'required',
            'city_id'=>'required',
            'id_number'=>'required'
           

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
            'country_id.required' => 'Please choose your country',
            'city_id.required' => 'Please choose your city',
            'region_id.required' => 'Please choose your region',
            'nationality_id.required' => 'Please choose your nationality',
            'first_name.required'=>'Please Add The first name',
            'middle_name.required'=>'Please Add The middle name',
            'last_name.required'=>'Please Add The last name',
            'gender.required'=>'Please Add The gender',
            'email.required'=>'Please Add The gender',
            'email.unique'=>'The email already in use',
            'phone.unique'=>'the phone number already in use',
            'phone.required'=>'the phone number already in use',
            'password.required'=>'Please add password',
            'password.confirmed'=>'wrong match password',
            'password_confirmation.required'=>'Please add password conformation',
            'country_id.required'=>'Please add country',
            'country_code.required'=>'Please add country code',
            'dial_code.required'=>'Please add dial code',
            'region_id.required'=>'Please add region id',
            'nationality_id.required'=>'Please add nationality id',
            'city_id.required'=>'Please add city id',
            'id_number.required'=>'Please add id number',
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
