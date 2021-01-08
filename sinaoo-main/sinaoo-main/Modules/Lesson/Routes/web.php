<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('lesson.')->middleware('can:admin')->prefix('lesson')->group(function() {
    Route::get('/', 'LessonController@index')->name('index');
    Route::post('/', 'LessonController@index');
    Route::get('/category', 'LessonController@category')->name('category');
    Route::post('/category', 'LessonController@category');
    Route::get('/detail/{lesson}', 'LessonController@detail')->name('detail');
    Route::post('/detail/{lesson}', 'LessonController@detail');
    Route::get('/questions/{lessondetail}', 'LessonController@question')->name('question');
    Route::post('/questions/{lessondetail}', 'LessonController@question');
    Route::get('/answers/{lessonquestion}', 'LessonController@answer')->name('answer');
    Route::post('/answers/{lessonquestion}', 'LessonController@answer');
});
