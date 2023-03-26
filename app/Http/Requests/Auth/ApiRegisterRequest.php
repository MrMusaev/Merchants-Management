<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ApiRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The :attribute field is required'),
            'email.required' => __('The :attribute field is required'),
            'password.required' => __('The :attribute field is required'),
            'email.unique' => __('This email has already registered in the system. Please, login or use another email!'),
            'password.confirmed' => __("Password validation must match to the password"),
        ];
    }
}
