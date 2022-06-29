<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_en'=>'required',
            'name_ar'=>'required',
            'description_en'=>'required',
            'description_ar'=>'required',
            'image'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'The image required',
            'name_ar.required' => 'The Name in arabic is required',
            'name_en.required' => 'The Name in english is required',
            'description_en.required' => 'The Description in english is required',
            'description_ar.required' => 'The Description in arabic is required',
        ];
    }
}
