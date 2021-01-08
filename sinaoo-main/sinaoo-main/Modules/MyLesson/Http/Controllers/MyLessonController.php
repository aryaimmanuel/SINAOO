<?php

namespace Modules\MyLesson\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonDetail;
use Modules\Lesson\Entities\LessonQuestion;
use Modules\Lesson\Entities\LessonQuestionAnswer;
use Modules\Lesson\Entities\LessonUser;
use Modules\MyLesson\Entities\LessonQuiz;

class MyLessonController extends Controller
{
    public function lesson(Lesson $lesson)
    {
        $title = $lesson->name;

        // cek sudah subscribe atau belum
        $cek = LessonUser::where('user_id', Auth::id())->where('lesson_id', $lesson->id)->first();
        if(is_null($cek)){
            // belum subscribe

            if($lesson->is_paid == 1){
                // jika berbayar
                if(Auth::user()->is_premium == 0){
                    return view('mylesson::subs', compact('title', 'lesson'));
                }else{
                    LessonUser::create([
                        'user_id' => Auth::id(),
                        'lesson_id' => $lesson->id,
                        'is_paid' => 1,
                        'order_date' => now(),
                        'purchase_date' => now()
                    ]);
                    return view('mylesson::index', compact('title', 'lesson'));
                }
            }else{
                // jika gratis
                LessonUser::create([
                    'user_id' => Auth::id(),
                    'lesson_id' => $lesson->id,
                    'is_paid' => 1,
                    'order_date' => now(),
                    'purchase_date' => now()
                ]);
                return view('mylesson::index', compact('title', 'lesson'));
            }
        }else{
            // sudah subscribe

            // cek berbayar atau tidak
            if($lesson->is_paid == 1){
                // jika berbayar
                if(Auth::user()->is_premium == 0){
                    return view('mylesson::subs', compact('title', 'lesson'));
                }else{
                    return view('mylesson::index', compact('title', 'lesson'));
                }
            }else{
                return view('mylesson::index', compact('title', 'lesson'));
            }
        }
    }

    public function questions(LessonDetail $lessondetail)
    {
        $title = "Post test : " . $lessondetail->name;
        $questions = $lessondetail->lesson_questions;

        // cek sudah pernah menjawab atau belum
        $cek = LessonQuiz::where('user_id', Auth::id())->where('lesson_detail_id', $lessondetail->id)->first();
        // if(!is_null($cek)) return redirect()->route('lesson.home', $lessondetail->lesson->id)->with('danger', "Error: Anda sudah pernah mengerjakan soal ini!");

        return view('mylesson::questions', compact('title', 'questions', 'lessondetail'));
    }

    public function store(Request $request, LessonDetail $lessondetail)
    {
        $i = 0;
        $nilai = 0;
        foreach ($request->soal as $soal) {
            $jawaban = LessonQuestionAnswer::where('lesson_question_id', $soal)->where('is_correct', 1)->first();
            $jawabanku = $_POST['jawaban-'. $soal] ?? null;

            // input jawaban dahulu
            $j = new LessonQuiz();
            $j->lesson_detail_id = $lessondetail->id;
            $j->lesson_question_id = $soal;
            $j->lesson_question_answer_id = $jawabanku;
            $j->user_id = Auth::id();
            $j->correct_is = $jawaban->id;

            // cek kebenarannya
            if($jawabanku == $jawaban->id){
                $j->is_correct = 1;
                $j->point = $jawaban->lesson_question->point;
                $i++;
                $nilai += $j->point;
            }

            $j->save();
        }

        if($i >= 1){
            return redirect()->route('lesson.home', $lessondetail->lesson->id)->with('success', "Anda telah berhasil menjawab dengan benar sebanyak $i jawaban. Nilai akhir adalah $nilai.");
        }else{
            return redirect()->route('lesson.home', $lessondetail->lesson->id)->with('danger', "Tidak ada jawaban yang benar");
        }
    }
}
