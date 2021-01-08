<?php

namespace Modules\MyLesson\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lesson\Entities\LessonDetail;
use Modules\Lesson\Entities\LessonQuestion;
use Modules\Lesson\Entities\LessonQuestionAnswer;

class LessonQuiz extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson_detail()
    {
        return $this->belongsTo(LessonDetail::class);
    }

    public function lesson_question()
    {
        return $this->belongsTo(LessonQuestion::class);
    }

    public function lesson_question_answer()
    {
        return $this->belongsTo(LessonQuestionAnswer::class);
    }
}
