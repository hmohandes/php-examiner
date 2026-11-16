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
        User::factory(300)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Exam::factory(100)->create()->each(function (Exam $exam) {

            $extra_question_count = fake()->numberBetween(0, 10);
            Question::factory($exam->question_count + $extra_question_count)
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


        $users = User::take(300)->get();

        $studentAbilities = [];

        foreach ($users as $user) {
            $studentAbilities[$user->id] = fake()->numberBetween(45, 95);
        }

        foreach ($users as $user) {

            $exams = Exam::take(20)->get();

            foreach ($exams as $exam) {

                $ability = $studentAbilities[$user->id];

                // Generate the randomized exam
                $studentExam = $exam->generate($user);

                // Answer every question randomly
                foreach ($studentExam->questions as $question) {

                    $answers = [
                        $question->answer_id_1,
                        $question->answer_id_2,
                        $question->answer_id_3,
                        $question->answer_id_4,
                    ];

                    $correctAnswer = Answer::where('question_id', $question->question_id)
                        ->where('correct', true)
                        ->first();

                    $wrongAnswers = Answer::where('question_id', $question->question_id)
                        ->where('correct', false)
                        ->pluck('id');

                    $selectedAnswer = fake()->boolean($ability)
                        ? $correctAnswer->id
                        : $wrongAnswers->random();

                    $question->update([
                        'answer_id' => $selectedAnswer,
                        'answered_at' => fake()->dateTimeBetween(
                            $studentExam->created_at,
                            $studentExam->end
                        ),
                    ]);
                }

                // Calculate the final result
                $studentExam->refresh();
                $studentExam->finish();
            }
        }
    }
}
