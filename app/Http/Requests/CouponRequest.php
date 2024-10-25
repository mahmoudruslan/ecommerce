<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|string|max:100',
            'value' => 'required|string|max:255|numeric',
            'description_en' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string|max:500',
            'use_times' => 'nullable|string|numeric',
            'used_times' => 'nullable|string|numeric',
            'start_date' => 'nullable|date|before:expire_date',
            'expire_date' => 'nullable|required_with:start_date|after:start_date|date',
            'greater_than' => 'nullable|numeric',
            'status' => 'max:1',

        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules = [
                'code' => 'required|string|max:255|unique:coupons,code,'. Crypt::decrypt($this->route()->coupon),
                'type' => 'required|string|max:100',
                'value' => 'required|string|max:255',
                'description_en' => 'nullable|string|max:500',
                'description_ar' => 'nullable|string|max:500',
                'use_times' => 'required|string|numeric',
                'used_times' => 'required|string|numeric',
                'start_date' => 'nullable|date|before:expire_date',
                'expire_date' => 'nullable|required_with:start_date|after:start_date|date',
                'greater_than' => 'required|numeric',
                'status' => 'max:1',
            ];
        }

        return $rules;
    }
}
