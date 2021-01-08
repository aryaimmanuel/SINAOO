<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson_detail()
    {
        return $this->belongsTo(LessonDetail::class);
    }

    public function lesson_question_answers()
    {
        return $this->hasMany(LessonQuestionAnswer::class);
    }
}
