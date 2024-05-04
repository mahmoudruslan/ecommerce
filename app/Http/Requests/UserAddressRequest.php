<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class UserAddressRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:6,50',
            'email' => 'required|string|email|max:255',
            'user_id' => 'nullable',
            'default_address' => 'nullable|numeric|max:1',
            'address_title_en' => 'nullable|string|max:255',
            'address_title_ar' => 'required|string|max:255',
            'address_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string|max:255',
            'address2_ar' => 'nullable|string|max:255',
            'address2_en' => 'nullable|string|max:255',
            'governorate_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'zip_code' => 'required|numeric|digits_between:6,50',
            'po_box' => 'required|numeric|digits_between:6,50',
        ];
    }
}
