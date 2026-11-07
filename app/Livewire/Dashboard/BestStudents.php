<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;

class BestStudents extends Component
{

    public function render()
    {
        $students = User::select('users.*')
            ->join('student_exams','users.id','=','student_exams.user_id')
            ->selectRaw('AVG(score) average')
            ->groupBy('users.id')
            ->orderByDesc('average')
            ->take(10)
            ->get();

        return view('livewire.dashboard.best-students',[
            'students'=>$students
        ]);
    }
}