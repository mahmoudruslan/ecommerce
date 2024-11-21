<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $result = [];
        if ($this->input('address_id')) {
            $result = [
                'address_id' => 'required|numeric',
            ];
        } else {
            $result =  [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|numeric|digits_between:6,50',
                'email' => 'required|email',
                'user_id' => 'nullable',
                'zip_code' => 'nullable|numeric|digits_between:1,10',
                'governorate_id' => 'required|numeric',
                'address' => 'required|string|max:255',
                'city_id' => 'required|numeric',
                'payment_method' => 'required|string'
            ];
        }
        return $result;
    }
}
