<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_question_id')->constrained()->onDelete('cascade');
            $table->text('answer')->default('<p>Jawaban</p>');
            $table->string('is_correct', 5)->default('0');
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
        Schema::dropIfExists('lesson_question_answers');
    }
}
