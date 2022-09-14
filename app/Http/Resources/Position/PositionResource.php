<?php

namespace App\Http\Resources\Position;

use App\Enums\GenderPositionEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class PositionResource extends JsonResource
{
    const AttributesNull = "مهم نیست";
    const SalaryNull = "توافقی";

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    #[ArrayShape(["id" => "integer", "title" => "string",
        "category" => "string",
        "min_age" => "integer",
        "max_age" => "integer", "education" => "string", "gender" => "string",
        "salary" => "integer", "location" => "string",
        "created_at" => "string", "expired_at" => "string",
        "lived_at" => "string"
    ])]
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "category" => $this->category,
            "min_age" => $this->min_age != null ? $this->min_age : self::AttributesNull,
            "max_age" => $this->max_age != null ? $this->max_age : self::AttributesNull,
            "education" => $this->eduation,
            "gender" => $this->gender != null ? GenderPositionEnum::{$this->gender}()->value : self::AttributesNull,
            "salary" => $this->salary != null ? number_format($this->salary) : self::SalaryNull,
            "location" => $this->location != null ? $this->location : self::AttributesNull,
            "created_at" => $this->created_at,
            "expired_at" => $this->expired_at,
            "lived_at" => $this->lived_at,
        ];
    }
}
