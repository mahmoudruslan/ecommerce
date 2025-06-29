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
            'has_variants' => 'required|boolean',
            'variants' => [
                Rule::requiredIf(isset($this->has_variants)),
                'array',
                'min:1',
            ],
            'variants.*.variant_price' => $this->variantFieldRules(),
            'variants.*.quantity' => $this->variantFieldRules('integer'),
            'variants.*.attributes' => $this->variantFieldRules('array'),
        ];
    }

    protected function variantFieldRules($type = 'numeric'): array
    {
        return [
            Rule::requiredIf($this->has('variants') && !empty($this->input('variants'))),
            $type,
            in_array($type, ['numeric', 'integer']) ? 'min:0' : '',
        ];
    }
}
