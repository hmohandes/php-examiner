<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentExam extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'ended_at',
        'score',
        'status',
    ];

    protected $casts = [
        'ended_at' => 'datetime',
        'status' => 'boolean',
        'score' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function calculateScore(): float
    {
        $correct = 0;

        foreach ($this->questions as $question) {

            if (!$question->answer_id) {
                continue;
            }

            $answer = Answer::find($question->answer_id);

            if ($answer && $answer->correct) {
                $correct++;
            }
        }
        
        return round(
            ($correct / $this->exam->question_count) * 100,
            2
        );
    }

    public function finish(): void
    {
        $score = $this->calculateScore();

        $this->update([
            'score' => $score,
            'status' => $score >= $this->exam->required_score,
        ]);
    }
}
