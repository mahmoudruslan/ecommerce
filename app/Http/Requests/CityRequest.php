<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class CityRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255|unique:cities,name_ar',
            'name_en' => 'required|string|max:255|unique:cities,name_en',
            'status' => 'nullable',
            'governorate_id' => 'required|numeric',
        ];


        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $id = Crypt::decrypt($this->route('city'));
            $rules = [
                'name_ar' => 'required|string|max:255|unique:cities,name_ar,'.$id,
                'name_en' => 'required|string|max:255|unique:cities,name_en,'.$id,
                'governorate_id' => 'required|numeric',
            ];
        }

        return $rules;
    }
}
