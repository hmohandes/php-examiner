<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Exam;

class HardestExams extends Component
{

    public function render()
    {
        $exams = Exam::select('exams.*')
            ->join('student_exams','student_exams.exam_id','=','exams.id')
            ->selectRaw('AVG(score) average')
            ->groupBy('exams.id')
            ->orderBy('average')
            ->take(10)
            ->get();

        return view('livewire.dashboard.hardest-exams',[
            'exams'=>$exams
        ]);
    }
}