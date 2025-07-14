<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'featured' => 'in:0,1',
            'status' => 'in:0,1',
            'images' => 'nullable|array',
            'images.*' => 'max:1024|mimes:jpg,jpeg,png|',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'featured' => $this->has('featured') ? $this->featured : 0,
            'status' => $this->has('status') ? $this->status : 0,
        ]);
    }

}
