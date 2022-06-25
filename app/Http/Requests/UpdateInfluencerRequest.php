<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Auth;

class UpdateInfluencerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
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
            'ad_price'=>'required',
            'ad_onsite_price'=>'required',
            'categories'=>'required',
            'region_id'=>'required',
            'ad_with_vat'=>'required',
            'ad_onsite_price_with_vat'=>'required',
            'bank_id'=>'required',
            'commercial_registration_no'=>'required',
            'bank_account_name'=>'required',
            'rep_city'=>'required',
            'rep_area'=>'required',
            'milestone'=>'required',
            'street'=>'required',
            'neighborhood'=>'required',
            'rep_full_name'=>'required',
            'status' => 'required',
            'rejected_note' => "required_if:status,==,rejected",
            'social_media' => 'required|array'
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
            'ads_out_country.required' => 'Please add if you can make ads outside of your country',
            'required_if'=>'Reject Note field is required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'error' => $validator->errors()->all(),
        'message' => $validator->errors()->all()[0],
        'status' => false
        ], 422));
    }
}
