<?php

namespace App\Http\Requests\Products;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RemoveImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        userAbility(['delete-products']);
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
            'media_id' => 'required|string',
            'product_id' => 'required|string'
        ];
    }

    public function passedValidation()
    {
        $product = Product::find($this->product_id);
        $mediaCount = $product->media()->count();
        $media = $product?->media()->where('id', $this->media_id)->first();

        if (!$media) {
            throw ValidationException::withMessages([
                'media' => ['Media not found for this product.']
            ]);
        }

        if ($mediaCount <= 1) {
            throw ValidationException::withMessages([
                'media' => ['Cannot delete the last image of this product.']
            ]);
        }
        $this->merge([
            'media' => $media
        ]);
    }

}
