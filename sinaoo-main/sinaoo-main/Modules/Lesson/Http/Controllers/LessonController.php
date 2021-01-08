<?php

namespace Modules\Lesson\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GroceryCrud\Core\GroceryCrud;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonCategory;
use Modules\Lesson\Entities\LessonDetail;
use Modules\Lesson\Entities\LessonQuestion;
use Modules\Lesson\Entities\LessonQuestionAnswer;

class LessonController extends Controller
{
    private function _getDatabaseConnection() {
        $databaseConnection = config('database.default');
        $databaseConfig = config('database.connections.' . $databaseConnection);


        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'database' => $databaseConfig['database'],
                'username' => $databaseConfig['username'],
                'password' => $databaseConfig['password'],
                'charset' => 'utf8'
            ]
        ];
    }

    private function _getGroceryCrudEnterprise() {
        $database = $this->_getDatabaseConnection();
        $config = config('grocerycrud');

        $crud = new GroceryCrud($config, $database);

        return $crud;
    }

    private function _show_output($output, $title = '') {
        if ($output->isJSONResponse) {
            return response($output->output, 200)
                  ->header('Content-Type', 'application/json')
                  ->header('charset', 'utf-8');
        }

        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $output = $output->output;

        return view('grocery', [
            'output' => $output,
            'css_files' => $css_files,
            'js_files' => $js_files,
            'title' => $title
        ]);
    }

    public function category()
    {
        $title = "Categories";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('lesson_categories');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Category', 'Categories');
        $crud->columns(['name', 'description', 'status_id', 'updated_at']);
        $crud->fields(['name', 'description', 'image', 'status_id']);
        $crud->requiredFields(['name', 'description', 'image', 'status_id']);
        $crud->setRelation('status_id', 'statuses', 'name');
        $crud->setFieldUpload('image', 'storage', '../storage');
        $crud->setTexteditor(['description']);
        $crud->displayAs([
            'status_id' => 'Status'
        ]);
        $crud->callbackAfterInsert(function ($s) {
            $lesson = LessonCategory::find($s->insertId);
            $lesson->touch();
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $lesson = LessonCategory::find($s->primaryKeyValue);
            $lesson->touch();
            return $s;
        });
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }

    public function index()
    {
        $title = "Lesson";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('lessons');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Lesson', 'Lessons');
        $crud->columns(['lesson_category_id', 'name', 'description', 'is_paid', 'status_id', 'updated_at']);
        $crud->fields(['lesson_category_id', 'is_paid', 'name', 'description', 'mentor', 'image', 'color', 'status_id']);
        $crud->requiredFields(['lesson_category_id', 'is_paid', 'name', 'description', 'mentor', 'image', 'color', 'status_id']);
        $crud->setRelation('status_id', 'statuses', 'name');
        $crud->setRelation('lesson_category_id', 'lesson_categories', 'name');
        $crud->setFieldUpload('image', 'storage', 'storage');
        $crud->fieldType('color', 'color');
        $crud->setTexteditor(['description']);
        $crud->fieldType('is_paid', 'checkbox_boolean');
        $crud->displayAs([
            'lesson_category_id' => 'Category',
            'status_id' => 'Status',
            'is_paid' => 'Berbayar'
        ]);
        $crud->callbackAfterInsert(function ($s) {
            $lesson = Lesson::find($s->insertId);
            $lesson->touch();
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $lesson = Lesson::find($s->primaryKeyValue);
            $lesson->touch();
            return $s;
        });
        $crud->setActionButton('Details', 'fa fa-eye', function ($row) {
            return route('lesson.detail', $row->id);
        });
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }

    public function detail(Lesson $lesson)
    {
        $title = "Lesson Details";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('lesson_details');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Lesson', 'Lessons');
        $crud->columns(['lesson_id', 'name', 'description', 'updated_at']);
        $crud->fields(['name', 'description']);
        $crud->requiredFields(['name', 'description']);
        $crud->setRelation('lesson_id', 'lessons', 'name');
        $crud->setTexteditor(['description']);
        $crud->displayAs([
            'lesson_id' => 'Lesson'
        ]);
        $crud->where([
            'lesson_id' => $lesson->id
        ]);
        $crud->callbackAfterInsert(function ($s) use($lesson) {
            $lessond = LessonDetail::find($s->insertId);
            $lessond->created_at = now();
            $lessond->lesson_id = $lesson->id;
            $lessond->save();
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $lesson = LessonDetail::find($s->primaryKeyValue);
            $lesson->touch();
            return $s;
        });
        $crud->setActionButton('Questions', 'fa fa-eye', function ($row) {
            return route('lesson.question', $row->id);
        });

        $output = $crud->render();

        return $this->_show_output($output, $title);
    }

    public function question(LessonDetail $lessondetail)
    {
        $title = "Questions for " . $lessondetail->name . " | " . $lessondetail->lesson->name;

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('lesson_questions');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Question', 'Questions');
        $crud->columns(['question', 'point', 'answers', 'updated_at']);
        $crud->fields(['question', 'point', 'answers']);
        $crud->requiredFields(['question', 'point', 'answers']);
        // $crud->addFields(['question', 'answers']);
        // $crud->editFields(['question']);
        // $crud->requiredFields(['question']);
        // $crud->setRelation('lesson_id', 'lessons', 'name');
        $crud->setTexteditor(['question']);
        $crud->displayAs([
            'answers' => 'Number of answers'
        ]);
        $crud->where([
            'lesson_detail_id' => $lessondetail->id
        ]);
        $crud->callbackBeforeInsert(function ($s) use($lessondetail) {
            $s->data['lesson_detail_id'] = $lessondetail->id;
            return $s;
        });
        $crud->callbackAfterInsert(function ($s) use($lessondetail) {
            $question = LessonQuestion::find($s->insertId);
            $question->created_at = now();
            $question->save();

            for($i = 1; $i <= $question->answers; $i++){
                $answer = new LessonQuestionAnswer();
                $answer->lesson_question_id = $question->id;
                $answer->save();
            }
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $lesson = LessonQuestion::find($s->primaryKeyValue);
            $lesson->touch();
            return $s;
        });
        $crud->setActionButton('Answers', 'fa fa-eye', function ($row) {
            return route('lesson.answer', $row->id);
        });

        $output = $crud->render();

        return $this->_show_output($output, $title);
    }

    public function answer(LessonQuestion $lessonquestion)
    {
        $title = "Answers for " . strip_tags($lessonquestion->question) ;

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('lesson_question_answers');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Question', 'Questions');
        $crud->unsetAdd()->unsetDelete()->unsetDeleteMultiple();
        $crud->columns(['answer', 'is_correct', 'updated_at']);
        $crud->fields(['answer', 'is_correct']);
        $crud->requiredFields(['answer']);
        $crud->setTexteditor(['answer']);
        // $crud->displayAs([
        //     'answers' => 'Number of answers'
        // ]);
        $crud->where([
            'lesson_question_id' => $lessonquestion->id
        ]);
        $crud->fieldType('is_correct', 'checkbox_boolean');
        $crud->callbackBeforeInsert(function ($s) use($lessonquestion) {
            $s->data['lesson_question_id'] = $lessonquestion->id;
            return $s;
        });
        $crud->callbackAfterInsert(function ($s) {
            $question = LessonQuestionAnswer::find($s->insertId);
            $question->created_at = now();
            $question->save();
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $lesson = LessonQuestionAnswer::find($s->primaryKeyValue);
            $lesson->touch();
            return $s;
        });

        $output = $crud->render();

        return $this->_show_output($output, $title);
    }
}
