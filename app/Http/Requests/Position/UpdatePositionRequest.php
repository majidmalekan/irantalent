<?php

namespace App\Http\Requests\Position;

use App\Enums\GenderPositionEnum;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;
use Spatie\Enum\Laravel\Rules\EnumRule;

class UpdatePositionRequest extends FormRequest
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
    #[Pure] public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'category' => ['sometimes', 'string'],
            'education' => ['sometimes', 'string'],
            'gender' => ['sometimes', new EnumRule(GenderPositionEnum::class)],
            'min_age' => ['sometimes', 'numeric'],
            'max_age' => ['sometimes', 'numeric'],
            'salary' => ['sometimes', 'numeric'],
            'location' => ['sometimes', 'string'],
            'expired_at' => ['sometimes', 'numeric'],
            'lived_at' => ['sometimes', 'numeric'],
        ];
    }
}
