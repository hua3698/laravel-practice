<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    return view('home');
});

Route::get('greet', function () {
    return 'hello world';
});

Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('signUp', 'App\Http\Controllers\LoginController@signUp')->name('signUp');
Route::post('signIn', 'App\Http\Controllers\LoginController@signIn')->name('signIn');

// 機房日誌
Route::get('log/form', function () {
    return view('log_form');
})->name('log_form');

Route::post('log/create', 'App\Http\Controllers\ServerLogController@createLog')->name('createLog');
Route::get('log/list', 'App\Http\Controllers\ServerLogController@showLogList')->name('log_list');
Route::get('log/{log_id}', 'App\Http\Controllers\ServerLogController@showSingleLog');
Route::get('log/{log_id}/edit', 'App\Http\Controllers\ServerLogController@editSingleLog');
Route::put('log/{log_id}/delete', 'App\Http\Controllers\ServerLogController@deleteSingleLog')->name('log_delete');