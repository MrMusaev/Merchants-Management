<?php

namespace App\Http\Requests\Merchants;

use App\Constants\Status;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'keyword' => 'nullable | string',
            'status' => 'integer | in:' . implode(',', array_keys(Status::getSelection())),
            'sort_field' => 'string | in:id,name,slug,status,created_at,updated_at',
            'per_page' => 'integer | max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'sort_field.in' => __("Sort field must be one of these: id, name, slug, status, created_at, updated_at")
        ];
    }
}
