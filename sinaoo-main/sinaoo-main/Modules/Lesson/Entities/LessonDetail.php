<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\MyLesson\Entities\LessonQuiz;

class LessonDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function lesson_questions()
    {
        return $this->hasMany(LessonQuestion::class);
    }

    public function lesson_quizzes()
    {
        return $this->hasMany(LessonQuiz::class);
    }
}
