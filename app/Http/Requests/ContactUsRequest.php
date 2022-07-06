<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'name'=>'required',
            'title'=>'required',
            'email'=>'required|email',
            'message'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please add name',
            'title.required' => 'Please add title',
            'email.required' => 'Please add email',
            'message.required' => 'Please add message',
            'email.email' => 'Please add correct email',
        ];
    }
}
