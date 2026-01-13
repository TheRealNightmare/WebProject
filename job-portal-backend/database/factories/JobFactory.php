<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'salary_range' => '$' . fake()->numberBetween(60, 100) . 'k - $' . fake()->numberBetween(110, 160) . 'k',
            'type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Remote']),
            'is_active' => true,
        ];
    }
}