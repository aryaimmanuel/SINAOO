<?php

use App\Status;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonCategory;
use Modules\Lesson\Entities\LessonDetail;
use Modules\Lesson\Entities\LessonQuestion;
use Modules\Lesson\Entities\LessonQuestionAnswer;
use Modules\User\Entities\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Role::create([
            'name' => 'Administrator'
        ]);
        Role::create([
            'name' => 'Member'
        ]);

        Status::create([
            'name' => 'Active'
        ]);
        Status::create([
            'name' => 'Inactive'
        ]);

        LessonCategory::create([
            'name' => 'IV-SD'
        ]);
        LessonCategory::create([
            'name' => 'PEMULA'
        ]);

        User::create([
            'name' => 'Admin',
            'last_name' => 'Sinaoo',
            'password' => Hash::make('password'),
            'email' => 'admin@sinaoo.id',
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Siswa',
            'last_name' => 'Sinaoo',
            'password' => Hash::make('password'),
            'email' => 'siswa@sinaoo.id',
            'role_id' => 2
        ]);

        for($a = 1; $a <= 10; $a++){
            $lesson = new Lesson();
            $lesson->lesson_category_id = 2;
            $lesson->name = Str::random(10);
            $lesson->description = Str::random(10);
            $lesson->mentor = Str::random(10);
            $lesson->color = '#000000';
            $lesson->status_id = 1;
            $lesson->save();
        }

        foreach(Lesson::all() as $lesson){
            for($a = 1; $a <= 5; $a++){
                $l_detail = new LessonDetail();
                $l_detail->lesson_id = $lesson->id;
                $l_detail->name = Str::random(10);
                $l_detail->description = Str::random(10);
                $l_detail->save();
            }
        }

        foreach(LessonDetail::all() as $detail){
            for($i=1; $i<=10; $i++){
                $q = new LessonQuestion();
                $q->lesson_detail_id = $detail->id;
                $q->question = "Pertanyaan $i";
                $q->point = 10;
                $q->answers = 4;
                $q->save();

                for($k=1; $k<=4; $k++){
                    $jawaban = ($k=='1') ? "1" : "0";
                    $j = new LessonQuestionAnswer();
                    $j->lesson_question_id = $q->id;
                    $j->answer = "Jawaban $k";
                    $j->is_correct = $jawaban;
                    $j->save();
                }
            }
        }
    }
}
