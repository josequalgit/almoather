<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdRequest extends FormRequest
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
            'type'=>'required',
            'logo'=>'required',
            'store'=>'required',
            'budget'=>'required',
            'onSite'=>'required',
            'about'=>'required',
            'status'=>'required',
            'country_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'category_id'=>'required',
            'date'=>'required|date',
            'image'=>'mimes:jpg,bmp,png',
            'social_media_id'=>'required',
            'video'=>'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:100000',
            'documnet'=>'mimes:jpg,bmp,png,pdf|max:2048'

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
            'type.required' => 'Please choose the ad type',
            'store.required' => 'Please add the store name',
            'budget.required' => 'Please add the ad budget',
            'onSite.required' => 'Please choose if the ad require to be onsite',
            'country_id.required' => 'Please choose the country',
            'city_id.required' => 'Please choose the city',
            'area_id.required' => 'Please choose the area',
            'category_id.required' => 'Please choose the category',
            'social_media_id.required' => 'Please add a social media',
            'video.max' => 'The Video Size max should be 100Mb',
            'document.max' => 'The Video Size max should be 100Mb',
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
