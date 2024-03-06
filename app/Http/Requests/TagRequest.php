<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TagRequest extends FormRequest
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
        $rules = [
            'name_ar' => 'required|string|max:255|unique:tags,name_ar',
            'name_en' => 'required|string|max:255|unique:tags,name_en',
        ];


        if (Request::input('id') != null) {
            $id = Crypt::decrypt(Request::input('id'));
            $rules = [
                'name_ar' => 'required|string|max:255|unique:tags,name_ar,'.$id,
                'name_en' => 'required|string|max:255|unique:tags,name_en,'.$id,
            ];
        }

        return $rules;
    }

    // public function messages(): array
    // {
    //     return [
    //         'name_ar.required' => __('This field is required'),
    //         'name_en.required' => __('This field is required'),
    //         // 'name_ar.unique' => __('This field must be unique'),
    //         // 'name_en.unique' => __('This field must be unique'),
    //         // 'image.required' => __('This field is required'),
    //     ];
    // }
}
