<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateExtraInfluncerRequest extends FormRequest
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
            'commercial_registration_no'=>'required',
            'tax_registration_number'=>'required',
            'rep_full_name'=>'required',
            'rep_area'=>'required',
            'rep_city'=>'required',
            'rep_street'=>'required',
            // 'tax_registration_number_file'=>'required',
            // 'commercial_registration_no_file'=>'required',
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
