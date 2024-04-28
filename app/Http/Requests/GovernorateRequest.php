<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class GovernorateRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255|unique:governorates,name_ar',
            'name_en' => 'required|string|max:255|unique:governorates,name_en',
            'status' => 'nullable',
        ];


        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $id = Crypt::decrypt($this->route('governorate'));
            $rules = [
                'name_ar' => 'required|string|max:255|unique:governorates,name_ar,'.$id,
                'name_en' => 'required|string|max:255|unique:governorates,name_en,'.$id,
                'status' => 'nullable',
            ];
        }

        return $rules;
    }
}
