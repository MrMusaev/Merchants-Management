<?php

namespace App\Http\Requests\Merchants;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'name' => 'string | max:255',
            'lat' => 'numeric',
            'lng' => 'numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => __("Name can be maximum 255 characters"),
        ];
    }
}
