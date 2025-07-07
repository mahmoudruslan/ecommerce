<?php

namespace App\Http\Requests\Variants;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVariantRequest extends FormRequest
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
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.variant_price' => ['required', 'string'],
            'variants.*.variant_quantity' => ['required', 'string'],
            'variants.*.attributes' => ['required', 'array'],
            'variants.*.attributes.*' => ['required', 'integer', 'exists:attribute_values,id'],
        ];
    }
    protected function passedValidation()
    {
        $this->merge([
            'has_variants' => true
        ]);
    }
}
