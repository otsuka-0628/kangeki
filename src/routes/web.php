<?php

use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TroupeController;
use App\Http\Controllers\PerformanceController;
use App\Http\controllers\AccountController;

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

    Route::get('/troupe', [TroupeController::class, 'show'])->name('troupe.show');

    Route::get('/troupe/edit', [TroupeController::class, 'edit'])->name('troupe.edit');


    Route::post('/troupe', [TroupeController::class, 'storeOrUpdate'])->name('troupe.store');



    Route::get('/performances/create', [PerformanceController::class, 'create'])->name('performances.create');

    Route::post('/performances', [PerformanceController::class, 'store'])->name('performances.store');

    Route::get('/performances/{id}', [Performancecontroller::class, 'detail'])->name('performances.detail');


    Route::get('/performances/{id}/edit', [PerformanceController::class, 'edit'])->name('performances.edit');

    Route::put('/performances/{id}', [PerformanceController::class, 'update'])->name('performances.update');

    Route::delete('/performances/{id}', [PerformanceController::class, 'destroy'])->name('performances.destroy');


    Route::get('/account', [AccountController::class, 'show'])->name('account.show');

    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');

    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

});





Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

