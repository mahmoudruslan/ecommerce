<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'

            // 'name_ar' => 'required|string|max:255|unique:categories,name_ar',
            // 'name_en' => 'required|string|max:255|unique:categories,name_en',
            // 'image' => 'required',

        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH')
        {
            // $id = Crypt::decrypt($this->route('category'));
            $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024'
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
