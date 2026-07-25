<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/exams/{exam}/generate', [ExamController::class, 'generate']);

Route::get('/student-exams/{student_exam}/', [StudentExamController::class,'show']);
Route::post('/student-exams/{student_exam}/answer', [StudentExamController::class,'storeAnswer']);

Route::post('/student-exams/{student_exam}/finish', [StudentExamController::class,'finish']);