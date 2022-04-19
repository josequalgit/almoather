<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePriceInfluncerRequest extends FormRequest
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
            'bank_id'=>'required',
            'bank_account_number'=>'required',
            'ad_price'=>'required',
            'ad_onsite_price'=>'required',
            'ad_with_vat'=>'required',
            'ad_onsite_price_with_vat'=>'required',
            'bank_account_name'=>'required',

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
