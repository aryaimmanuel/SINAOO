<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_detail_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('lesson_question_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('lesson_question_answer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->char('is_correct')->default('0');
            $table->unsignedBigInteger('correct_is')->nullable();
            $table->unsignedBigInteger('point')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_quizzes');
    }
}
