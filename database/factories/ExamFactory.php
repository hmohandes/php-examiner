<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 year', 'today');

        // Exam duration once a student starts
        $duration = fake()->randomElement([30, 45, 60, 90, 120]);

        // Availability window
        $daysAvailable = fake()->numberBetween(1, 30);

        return [
            'name' => trim(fake()->word()),
            'start' => $start,
            'end' => (clone $start)->modify("+{$daysAvailable} days"),
            'duration' => $duration,
            'question_count' => fake()->numberBetween(5, 40),
            'required_score' => fake()->numberBetween(50, 85),
        ];
    }
}