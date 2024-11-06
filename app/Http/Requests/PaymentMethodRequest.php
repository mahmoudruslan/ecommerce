<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:payment_methods,code',
            'driver_name' => 'required|unique:payment_methods,driver_name',
            'merchant_email' => 'nullable|email',
            'username' => 'nullable',
            'password' => 'nullable',
            'secret' => 'nullable',
            'sandbox_username' => 'nullable',
            'sandbox_password' => 'nullable',
            'sandbox_secret' => 'nullable',
            'sandbox' => 'nullable',
            'status' => 'nullable',
        ];


        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $id = $this->route('payment_method');

            $rules = [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:payment_methods,code,' . $id,
                'driver_name' => 'required|unique:payment_methods,driver_name,' . $id,
                'merchant_email' => 'nullable|email',
                'username' => 'nullable',
                'password' => 'nullable',
                'secret' => 'nullable',
                'sandbox_username' => 'nullable',
                'sandbox_password' => 'nullable',
                'sandbox_secret' => 'nullable',
                'sandbox' => 'nullable',
                'status' => 'nullable',
            ];
        }

        return $rules;
    }
}
