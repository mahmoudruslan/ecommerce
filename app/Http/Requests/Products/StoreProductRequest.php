<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        userAbility(['store-products']);
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description_ar' => 'required|string|max:500',
            'description_en' => 'required|string|max:500',
            'video_link' => 'nullable|string|max:500',
            'iframe' => 'nullable|string|max:500',
            'category_id' => 'required|string|max:50',
            'featured' => 'max:1',
            'status' => 'max:1',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'sizes' => 'nullable|array',
            'sizes.*.selected' => 'nullable|boolean',
            'sizes.*.quantity' => 'nullable|integer|min:0'
        ];
    }

}
