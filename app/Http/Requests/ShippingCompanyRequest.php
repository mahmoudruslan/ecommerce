<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class ShippingCompanyRequest extends FormRequest
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
            'code' => 'required|numeric|unique:shipping_companies,code',
            'description_ar' => 'required|unique:shipping_companies,description_ar',
            'description_en' => 'required|unique:shipping_companies,description_en',
            'fast' => 'required',
            'coast' => 'required|numeric',
            'status' => 'nullable|numeric',
            'governorates' => 'required',
        ];


        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $id = Crypt::decrypt($this->route('shipping_company'));
            $rules = [
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'code' => 'required|numeric|unique:shipping_companies,code,' . $id,
                'description_ar' => 'required|unique:shipping_companies,description_ar,' . $id,
                'description_en' => 'required|unique:shipping_companies,description_en,' . $id,
                'fast' => 'required',
                'coast' => 'required|numeric',
                'status' => 'nullable|numeric',
                'governorates' => 'required',
            ];
        }

        return $rules;
    }
}
