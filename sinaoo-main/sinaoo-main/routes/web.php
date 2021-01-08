<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/testing', function () {
    $ezpay = config('app.ezpay') . "<br>";
    $cilik = config('app.cilik') . "<br>";
    $smart = config('app.smart') . "<br>";
    $jogja = config('app.jogja') . "<br>";
    $tebar = config('app.tebar') . "<br>";
    $sinao = config('app.sinao') . "<br>";

    $teks = $ezpay . $cilik . $smart . $jogja . $tebar . $sinao;
    return $teks;
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile', function(){
    return redirect()->away('http://smartcity.kodekodeku.com/profile');
})->name('profile')->middleware('auth');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');



Route::middleware('auth', 'can:member')->group(function(){
    Route::post('/premium', 'HomeController@premium')->name('premium');
    Route::get('/premium', 'HomeController@premium_data')->name('premium_data');
});
