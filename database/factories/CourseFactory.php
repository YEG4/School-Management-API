<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'code' => strtoupper(fake()->unique()->bothify('??-###')),
            'description' => fake()->text(100),
            'hours' => fake()->randomFloat(1, 0.5, 200.0),
        ];
    }
}
