<?php

namespace Database\Factories;

use App\Enums\EnumerationType as Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enumeration>
 */
class EnumerationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'type' => Type::ISSUE_PRIORITY,
        ];
    }
}
