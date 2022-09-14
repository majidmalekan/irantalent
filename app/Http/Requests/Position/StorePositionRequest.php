<?php

namespace App\Http\Requests\Position;

use App\Enums\GenderPositionEnum;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;
use Spatie\Enum\Laravel\Rules\EnumRule;

class StorePositionRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'category' => ['required', 'string'],
            'education' => ['required', 'string'],
            'gender' => ['sometimes', new EnumRule(GenderPositionEnum::class)],
            'min_age' => ['sometimes', 'numeric'],
            'max_age' => ['sometimes', 'numeric'],
            'salary' => ['sometimes', 'numeric'],
            'location' => ['sometimes', 'string'],
            'expired_at' => ['required', 'numeric'],
            'lived_at' => ['required', 'numeric'],
        ];
    }
}
