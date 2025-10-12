<?php

namespace App\Http\Requests\Store\Cart;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddToCartRequest extends FormRequest
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
        return [];
    }

    protected function prepareForValidation()
    {
        // Validate that the variant exists for the given product
        $variant = Variant::where('product_id', $this->route('product_id'))
            ->where('primary_attribute_value_id', $this->primary_value_id)
            ->where('secondary_attribute_value_id', $this->secondary_value_id)
            ->first();
        if (!$variant) {
            throw ValidationException::withMessages([
                'variant' => [__('The selected variant is not available. Please choose a different variant.')],
            ]);
        }
        $product = Product::with(['variants', 'firstMedia'])->find($this->route('product_id'));
        if (!$product) {
            throw ValidationException::withMessages([
                'variant' => [__('The selected product is not available. Please choose a different product.')],
            ]);
        }
        $this->merge([
            'product' => $product,
            'variant' => $variant,
        ]);
    }
}
