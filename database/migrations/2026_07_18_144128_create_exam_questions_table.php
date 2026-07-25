<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_exam_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('answer_id_1')->constrained('answers');
            $table->foreignId('answer_id_2')->constrained('answers');
            $table->foreignId('answer_id_3')->constrained('answers');
            $table->foreignId('answer_id_4')->constrained('answers');

            $table->foreignId('answer_id')
                ->nullable()
                ->constrained('answers');

            $table->dateTime('answered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
