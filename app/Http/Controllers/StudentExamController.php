<?php

namespace App\Http\Controllers;

use App\Models\StudentExam;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentExam $studentExam)
    {

        abort_if($studentExam->answered_at, 403, 'This exam has already been completed.');

        $studentExam->load([
            'questions.question',
            'questions.question.answers',
        ]);

        return response()->json([
            'id' => $studentExam->id,
            'end' => $studentExam->end,
            'questions' => $studentExam->questions->map(function ($item) {

                return [
                    'id' => $item->question->id,
                    'text' => $item->question->text,

                    'selected_answer' => $item->answer_id,

                    'answers' => collect([
                        $item->answer_id_1,
                        $item->answer_id_2,
                        $item->answer_id_3,
                        $item->answer_id_4,
                    ])->map(function ($answerId) use ($item) {

                        $answer = $item->question
                            ->answers
                            ->firstWhere('id', $answerId);

                        return [
                            'id' => $answer->id,
                            'text' => $answer->text,
                        ];
                    })->values()
                ];
            })
        ]);
    }

    public function storeAnswer(Request $request, StudentExam $studentExam)
    {
        // abort_if($studentExam->status, 403);

        abort_if(
            now()->lt($studentExam->created_at) || now()->gt($studentExam->ended_at),
            403,
            'This exam is not currently available.'
        );

        $examQuestion = $studentExam
            ->questions()
            ->where('question_id', $request->question_id)
            ->firstOrFail();

        $validAnswers = [
            $examQuestion->answer_id_1,
            $examQuestion->answer_id_2,
            $examQuestion->answer_id_3,
            $examQuestion->answer_id_4,
        ];

        abort_unless(
            in_array($request->answer_id, $validAnswers),
            422,
            'Invalid answer.'
        );

        $examQuestion->update([
            'answer_id' => $request->answer_id,
            'answered_at' => now(),
        ]);

        return response()->json([
            'message' => 'Answer saved.'
        ]);
    }

    public function finish(StudentExam $studentExam)
    {
        // abort_if($studentExam->status, 403);

        $studentExam->load('exam');

        $studentExam->finish();

        return response()->json([
            'score' => $studentExam->score,
            'passed' => $studentExam->status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
