<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class SearchPositionRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "offset" => ['required', 'numeric'],
            'perPage' => ['required', 'numeric'],
            'sort_key' => ['sometimes', 'string'],
            'search_key' => ['sometimes', 'string'],
            'search_value' => [new RequiredIf($this->has('search_key')), 'string'],
            'range_key' => ['sometimes', 'string', Rule::in(['age', 'created_at', 'expired_at'])],
            'range_gte' => [new RequiredIf($this->has('range_key')), 'string'],
            'range_lte' => [new RequiredIf($this->has('range_key')), 'string'],
            'sort_direction' => [new RequiredIf($this->has('sort_key')), Rule::in(['desc', 'asc'])],
            'title' => ['sometimes', 'string'],
        ];
    }
}
