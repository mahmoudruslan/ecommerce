<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class ProductRequest extends FormRequest
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

        $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description_ar' => 'required|string|max:500',
            'description_en' => 'required|string|max:500',
            'quantity' => 'required|string|max:50',
            'category_id' => 'required|string|max:50',
            'featured' => 'max:1',
            'status' => 'max:1',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',

        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            // $id = Crypt::decrypt($this->route('product'));
            $rules = [
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'price' => 'required|string|max:255',
                'description_ar' => 'required|string|max:500',
                'description_en' => 'required|string|max:500',
                'quantity' => 'required|string|max:50',
                'category_id' => 'required|string|max:50',
                'featured' => 'max:1',
                'status' => 'max:1',
                'images' => 'required|array',
                'images.*' => 'max:1024',
            ];
        }

        return $rules;
    }

    // public function messages(): array
    // {
    //     return [
    //         'name_ar.required' => __('This field is required'),
    //         'name_en.required' => __('This field is required'),
    //         // 'image.required' => __('This field is required'),
    //     ];
    // }
}
