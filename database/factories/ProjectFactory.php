<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(),
            'descrption' => implode("\n", fake()->paragraphs()),
            'status' => ProjectStatus::ACTIVE,
            'inherit_members' => null,
            'is_public' => false,
            'parent_id' => null,
        ];
    }
}
