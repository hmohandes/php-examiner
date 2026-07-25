<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'duration',
        'question_count',
        'required_score',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function generate(User $user): StudentExam
    {
        return DB::transaction(function () use ($user) {

            $studentExam = StudentExam::create([
                'user_id' => $user->id,
                'exam_id' => $this->id,
                'ended_at' => now()->addMinutes($this->duration),
            ]);

            $questions = $this->questions()
                ->inRandomOrder()
                ->limit($this->question_count)
                ->get();

            foreach ($questions as $question) {

                $answers = $question->answers()
                    ->inRandomOrder()
                    ->pluck('id')
                    ->values();

                ExamQuestion::create([
                    'student_exam_id' => $studentExam->id,
                    'question_id' => $question->id,

                    'answer_id_1' => $answers[0],
                    'answer_id_2' => $answers[1],
                    'answer_id_3' => $answers[2],
                    'answer_id_4' => $answers[3],
                ]);
            }

            return $studentExam;
        });
    }
}