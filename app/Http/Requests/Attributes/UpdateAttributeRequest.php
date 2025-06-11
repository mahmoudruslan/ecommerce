<?php

namespace App\Http\Requests\Attributes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
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
        $id = $this->route('attribute')->id;

        return [
            'name_ar' => 'required|unique:attributes,name_ar,' . $id,
            'name_en' => 'required|unique:attributes,name_en,' . $id,
            'code' => 'required|unique:attributes,code,' . $id,
            'type' => 'required',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'code' => strtolower($_POST['name_en']),
        ]);
    }
}
