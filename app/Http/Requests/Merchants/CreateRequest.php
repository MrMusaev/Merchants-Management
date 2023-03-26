<?php

namespace App\Http\Requests\Merchants;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'merchant_id' => 'integer',
            'name' => 'required | string | max:255',
            'lat' => 'required | numeric',
            'lng' => 'required | numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => __("Name can be maximum 255 characters"),
        ];
    }
}
