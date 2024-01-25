<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServerLogController;
use App\Http\Controllers\MemberController;

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

Route::get('login', [LoginController::class, 'checkIsLogin'])->name('login');
Route::post('signIn', [LoginController::class, 'signIn'])->name('signIn');
Route::post('validOTP', [LoginController::class, 'validOTP'])->name('validOTP');
Route::get('logout', [LoginController::class, 'logout']);

Route::middleware(['web', 'login'])->group(function () 
{
    // 機房日誌
    Route::get('log/form', function () {
        return view('log.form');
    })->name('log_form');

    Route::post('log/create', [ServerLogController::class, 'createLog'])->name('createLog');
    Route::get('log/list', [ServerLogController::class, 'showLogList'])->name('log_list');
    Route::get('log/search', [ServerLogController::class, 'searchLogList'])->name('')->name('log/search');
    Route::get('log/{log_id}', [ServerLogController::class, 'showSingleLog']);
    Route::get('log/{log_id}/edit', [ServerLogController::class, 'editSingleLog'])->name('log.edit');
    Route::post('log/{log_id}/save', [ServerLogController::class, 'saveSingleLog'])->name('log.edit.done');
    Route::put('log/{log_id}/delete', [ServerLogController::class, 'deleteSingleLog'])->name('log.delete');

    // 使用者專區
    Route::get('member/create', function () {
        return view('member.register');
    });
    Route::get('member/list', [MemberController::class, 'showMemberList'])->name('member_list');
    Route::post('member/create', [MemberController::class, 'createMember'])->name('createMember');
    Route::get('member/right', [MemberController::class, 'getMemberRightList']);
    Route::put('member/right', [MemberController::class, 'modifyMemberRight']);
    Route::put('member/list/key', [MemberController::class, 'renewMemberKey'])->name('memberRenewKey');
    Route::put('member/list/siglekey', [MemberController::class, 'renewOne'])->name('renewOne');
    Route::delete('member', [MemberController::class, 'deleteMemberByEmail'])->name('delMember');

    Route::post('file/upload', [MemberController::class, 'showMemberList'])->name('file');
});
