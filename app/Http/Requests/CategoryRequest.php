<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'

        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH')
        {
            // $id = Crypt::decrypt($this->route('category'));
            $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'
            ];
        }
        return $rules;
    }
}
