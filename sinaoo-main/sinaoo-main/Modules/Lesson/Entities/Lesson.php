<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson_category()
    {
        return $this->belongsTo(LessonCategory::class);
    }

    public function lesson_details()
    {
        return $this->hasMany(LessonDetail::class);
    }
}
