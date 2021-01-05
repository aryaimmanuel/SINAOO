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

Route::name('lesson.')->middleware('auth')->prefix('my-lesson')->group(function() {
    Route::get('/{lesson}', 'MyLessonController@lesson')->name('home');
    Route::get('/post-test/{lessondetail}', 'MyLessonController@questions')->name('questions');
    Route::post('/post-test/{lessondetail}', 'MyLessonController@store')->name('store');
});
