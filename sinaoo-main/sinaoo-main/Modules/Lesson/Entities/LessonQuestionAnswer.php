<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonQuestionAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson_question()
    {
        return $this->belongsTo(LessonQuestion::class);
    }
}
