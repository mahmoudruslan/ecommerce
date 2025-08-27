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
        'product_id' => [
            'required',
            Rule::unique('variants')->where(function ($query) {
                return $query->where('product_id', $this->product_id)
                             ->where('primary_attribute_id', $this->primary_attribute_id)
                             ->where('primary_attribute_value_id', $this->primary_attribute_value_id)
                             ->where('secondary_attribute_id', $this->secondary_attribute_id)
                             ->where('secondary_attribute_value_id', $this->secondary_attribute_value_id);
            })->ignore($this->route('variant')),
        ],
        'quantity' => ['required', 'string'],
        'primary_attribute_value_id' => 'required|string',
        'secondary_attribute_value_id' => 'required|string',
        'images' => ['nullable', 'array', 'min:1'],
        'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
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
