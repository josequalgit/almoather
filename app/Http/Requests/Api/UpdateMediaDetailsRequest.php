<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMediaDetailsRequest extends FormRequest
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
            'nick_name'=>'required',
            'bio'=>'required',
            'is_vat'=>'required',
            'ads_out_country'=>'required',
            'snap_chat_views'=>'required',
            'milestone'=>'required',
            'street'=>'required',
            'neighborhood'=>'required',
            'address'=>'required',
            'social_media'=>'required',
            'categories'=>'required',
            'preferred_socialMedias'=>'required',
            //'snap_chat_video'=>'required',
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
