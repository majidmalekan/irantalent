<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use JetBrains\PhpStorm\ArrayShape;

class IndexPositionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    #[ArrayShape(["page" => "integer[]", 'perPage' => "integer[]"])]
    public function rules(): array
    {
        return [
            "page" => ['required', 'numeric'],
            'perPage' => ['sometimes', 'numeric'],
        ];
    }
}
