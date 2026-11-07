<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Exam;
use App\Models\StudentExam;

class StatisticsCards extends Component
{
    public function render()
    {
        return view('livewire.dashboard.statistics-cards', [

            'students' => User::count(),

            'exams' => Exam::count(),

            'attempts' => StudentExam::count(),

            'average' => round(StudentExam::avg('score'),2),

        ]);
    }
}