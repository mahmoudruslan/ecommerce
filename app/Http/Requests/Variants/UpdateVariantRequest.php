<?php

namespace App\Http\Requests\Variants;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateVariantRequest extends FormRequest
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
            'price' => ['required', 'string'],
            'quantity' => ['required', 'string'],
            'attributes' => ['required', 'array'],
            'attributes.*' => ['required', 'integer', 'exists:attribute_values,id'],
            'images' => ['nullable', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'The price is required.',
            'quantity.required' => 'The quantity is required.',
            'product_id.required' => 'product not found.',
            'attributes.required' => 'The attributes is required.',
            'attributes.*.required' => 'The attribute is required.',
            'attributes.*.integer' => 'The attribute must be an integer.',
            'attributes.*.exists' => 'The attribute does not exist.',

        ];
    }
}
