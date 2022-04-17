<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
            'full_name'=>'required',
            'phone'=>'required',
            'country_id'=>'required',
            'region_id'=>'required',
            'nationality_id'=>'required',
            'city_id'=>'required',
            'gender'=>'required'
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
        'status' => config('global.WRONG_VALIDATION_STATUS')
        ],config('global.WRONG_VALIDATION_STATUS')));
    }
}
