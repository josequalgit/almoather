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
            'last_name'=>'required',
            'phone'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation' => 'required',
            'email'=>'required|unique:users',
            'country_id'=>'required',
            'image'=>'required',
            'region_id'=>'required',
            'nationality_id'=>'required',
            'city_id'=>'required',
            'id_number'=>'required',
            'commercial_registration_no'=>'required',
            'commercial_registration_no_files'=>'required',
            'tax_registration_number'=>'required',
            'tax_registration_number_file'=>'required',
            'starting_date'=>''


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
            'nationality_id.required' => 'Please choose your nationality'
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
