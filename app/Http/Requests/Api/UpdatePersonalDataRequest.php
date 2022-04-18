<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePersonalDataRequest extends FormRequest
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
            'country_id'=>'required',
            'birthday'=>'required',
            'nationality_id'=>'required',
            'id_number'=>'required',
            'city_id'=>'required',
            //'email'=>'required',
            'name'=>'required',
            'is_vat'=>'required',
            'region_id'=>'required',
            'phone'=>'required',
            'bank_account_first_name'=>'required',
            'bank_account_middle_name'=>'required',
            'bank_account_last_name'=>'required',
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
