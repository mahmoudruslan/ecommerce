<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'mobile' => 'required|numeric|digits_between:6,50|unique:users,mobile,' . auth()->id(),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable||string|min:8|confirmed',
        ];
    }
}
