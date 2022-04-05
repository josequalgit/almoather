<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
            'rep_id_number_name'=>'required',
            'rep_phone_number'=>'required',
            'rep_email'=>'required',
        ];
    }
}
