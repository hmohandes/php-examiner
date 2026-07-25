<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Exam;
use App\Models\User;

class ExamController extends Controller
{
    public function generate(Exam $exam)
    {
        $user = User::firstOrFail(); // assuming a test user

        // Verify the exam is currently available
        abort_if(
            now()->lt($exam->start) || now()->gt($exam->end),
            403,
            'This exam is not currently available.'
        );

        // Prevent multiple active attempts
        if (
            $user->studentExams()
                ->where('exam_id', $exam->id)
                // ->where('status', false)
                ->exists()
        ) {
            return response()->json([
                'message' => 'The user already has an active attempt for this exam.'
            ], 409);
        }

        $studentExam = $exam->generate($user);

        return response()->json([
            'message' => 'Exam generated successfully.',
            'student_exam_id' => $studentExam->id,
            'end' => $studentExam->end,
        ], 201);
    }
}
