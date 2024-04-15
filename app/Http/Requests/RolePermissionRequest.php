<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RolePermissionRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:'.config('permission.table_names.roles', 'roles').',name',

            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules = [
                'name' => 'required|string|max:255|unique:'.config('permission.table_names.roles', 'roles').',name,'. Crypt::decrypt($this->route()->permission_role),
                'permissions' => 'required|array',
                'permissions.*' => 'string'
            ];
        }

        return $rules;
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.required' => __('This field is required'),
    //         'permissions.required' => __('you must choose permission'),

    //         // 'email.email' => __('This field must be an email'),
    //         'name.max' => __('This is field must be no more than 255 characters'),
    //     ];
    // }
}
