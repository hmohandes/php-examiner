<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Exam::factory(5)->create()->each(function (Exam $exam) {

            Question::factory($exam->question_count + 5)
                ->create([
                    'exam_id' => $exam->id,
                ])
                ->each(function (Question $question) {

                    $correct = fake()->numberBetween(1, 4);

                    for ($i = 1; $i <= 4; $i++) {
                        Answer::factory()->create([
                            'question_id' => $question->id,
                            'correct' => $i === $correct,
                        ]);
                    }
                });
        });
    }
}
