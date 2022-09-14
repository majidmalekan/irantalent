<?php

namespace Database\Factories;

use App\Enums\GenderPositionEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Enum\Faker\FakerEnumProvider;

/**
 * @extends Factory
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minAge = $this->faker->randomDigit();
        $maxAge = $minAge + $this->faker->randomDigit();
        $this->faker->addProvider(new FakerEnumProvider($this->faker));
        return [
            'title' => $this->faker->jobTitle,
            'category' => $this->faker->text,
            'education' => $this->faker->randomElement(["BSc", "MD", "PhD", "Diploma"]),
            'min_age' => $minAge,
            'max_age' => $maxAge,
            'gender' => $this->faker->randomEnumValue(GenderPositionEnum::class),
            "salary" => $this->faker->randomNumber($this->faker->randomDigit()),
            "location" => $this->faker->city,
            "expired_at" => Carbon::now()->addDays($this->faker->randomDigit()),
            "lived_at" => Carbon::now()->addDays($this->faker->randomDigit()),
        ];
    }
}
