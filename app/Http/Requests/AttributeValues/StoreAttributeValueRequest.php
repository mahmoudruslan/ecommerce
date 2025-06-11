<?php

namespace App\Http\Requests\AttributeValues;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeValueRequest extends FormRequest
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
            'attribute_id' => 'required|string',
            'value_ar' => 'required|string|unique:attribute_values,value_ar',
            'value_en' => 'required|string|unique:attribute_values,value_en'
        ];
    }
}
