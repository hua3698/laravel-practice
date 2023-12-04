<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

use PragmaRX\Google2FAQRCode\Google2FA;

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

Route::post('Register', 'App\Http\Controllers\LoginController@signUp')->name('signUp');
Route::post('signIn', 'App\Http\Controllers\LoginController@signIn')->name('signIn');
Route::get('logout', 'App\Http\Controllers\LoginController@logout');

// 機房日誌
Route::get('log/form', function () {
    return view('log_form');
})->name('log_form')->middleware(Authenticate::class);

Route::post('log/create', 'App\Http\Controllers\ServerLogController@createLog')->name('createLog');
Route::get('log/list', 'App\Http\Controllers\ServerLogController@showLogList')->name('log_list');
Route::get('log/{log_id}', 'App\Http\Controllers\ServerLogController@showSingleLog');
Route::get('log/{log_id}/edit', 'App\Http\Controllers\ServerLogController@editSingleLog')->name('log.edit');
Route::post('log/{log_id}/save', 'App\Http\Controllers\ServerLogController@saveSingleLog')->name('log.edit.done');
Route::put('log/{log_id}/delete', 'App\Http\Controllers\ServerLogController@deleteSingleLog')->name('log.delete');

// 會員專區
Route::get('member', 'App\Http\Controllers\MemberController@showMemberList');

Route::get('test', function () {
    $google2fa  = new Google2FA();
        
    // $companyName = 'a';
    // $companyEmail = 'a';
    // $secretKey = $google2fa->generateSecretKey();

    // $inlineUrl = $google2fa->getQRCodeInline(
    //     $companyName,
    //     $companyEmail,
    //     $secretKey
    // );

    $secret = '123456';
    $secretKey = 'WVYBTW66DOZIZTH5';
    $valid = $google2fa->verifyKey($secretKey, $secret);
    dd($valid);
    // return view('home', ['inlineUrl' => $inlineUrl, 'key' => $secretKey]);
});