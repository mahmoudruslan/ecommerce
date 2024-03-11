<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class UserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'mobile' => 'required|numeric|digits_between:6,50|unique:users',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $id = Crypt::decrypt($this->route('user'));
            $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'mobile' => 'required|numeric|digits_between:6,50|unique:users,mobile,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:8|confirmed',
            ];
        }

        return $rules;
    }

    // public function messages(): array
    // {
    //     return [
    //         'first_name.required' => __('This field is required'),
    //         'last_name.required' => __('This field is required'),
    //         'username.required' => __('This field is required'),
    //         'mobile.required' => __('This field is required'),
    //         'image.required' => __('This field is required'),
    //         'email.required' => __('This field is required'),

    //     ];
    // }
}
