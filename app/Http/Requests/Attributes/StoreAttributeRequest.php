<?php

namespace App\Http\Requests\Attributes;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeRequest extends FormRequest
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
            'name_ar' => 'required|unique:attributes,name_ar',
            'name_en' => 'required|unique:attributes,name_en',
            'type' => 'required',
            'code' => 'required|unique:attributes,code',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'code' => strtolower($_POST['name_en']),
        ]);
    }
}
