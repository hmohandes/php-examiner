<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('yesterday', 'today');

        // Exam duration once a student starts
        $duration = fake()->randomElement([30, 45, 60, 90, 120]);

        // Availability window
        $daysAvailable = fake()->numberBetween(1, 14);

        return [
            'name' => fake()->word(),
            'start' => $start,
            'end' => (clone $start)->modify("+{$daysAvailable} days"),
            'duration' => $duration,
            'question_count' => fake()->numberBetween(5, 20),
            'required_score' => fake()->numberBetween(50, 90),
        ];
    }
}