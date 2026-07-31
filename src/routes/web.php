<?php

use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TroupeController;
use App\Http\Controllers\PerformanceController;

Route::get('/', function () {
    return view('auth.register-top');
});

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/user-login', function () {
    return view('auth.user-login');
})->name('login');

Route::post('/user-login', [LoginController::class, 'login']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/password/update', [ResetPasswordController::class, 'update'])->name('password.update');

Route::get('/user-register', [RegisterController::class, 'showRegisterForm'])->name('user-register');

Route::post('/user-register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 劇団情報の表示画面
    Route::get('/troupe', [TroupeController::class, 'show'])->name('troupe.show');

    // 劇団情報の入力・編集フォーム画面
    Route::get('/troupe/edit', [TroupeController::class, 'edit'])->name('troupe.edit');

    // 保存・更新処理
    Route::post('/troupe', [TroupeController::class, 'storeOrUpdate'])->name('troupe.store');

    //公演情報登録画面を表示するURL
    Route::get('/performances/create', [PerformanceController::class, 'create'])->name('performances.create');

    //フォームの入力データを保存するURL
    Route::post('/performances', [PerformanceController::class, 'store'])->name('performances.store');
});




// 公演登録画面（create）を開くための仮ルーティング
Route::get('/performances/create', [PerformanceController::class, 'create'])->name('performances.create');

// フォーム送信（保存）の処理用ルーティング（formのアクションで使ってるから書いておく）
Route::post('/performances', [PerformanceController::class, 'store'])->name('performances.store');




Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

