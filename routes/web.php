<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\BestStudents;
use App\Livewire\Dashboard\HardestExams;
use App\Livewire\Dashboard\DifficultQuestions;
use App\Livewire\Dashboard\StudentPerformance;
use App\Livewire\Dashboard\ExamPerformance;

Route::prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Main dashboard
        Route::get('/', Dashboard::class)
            ->name('index');

        // Reports
    //     Route::get('/students', BestStudents::class)
    //         ->name('students');

    //     Route::get('/exams', HardestExams::class)
    //         ->name('exams');

    //     Route::get('/questions', DifficultQuestions::class)
    //         ->name('questions');

    //     // Individual reports
    //     Route::get('/students/{user}', StudentPerformance::class)
    //         ->name('students.show');

    //     Route::get('/exams/{exam}', ExamPerformance::class)
    //         ->name('exams.show');
});