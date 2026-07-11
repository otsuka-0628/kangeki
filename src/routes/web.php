<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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


Route::get('/user-register', [RegisterController::class, 'showRegisterForm'])->name('user-register');

Route::post('/user-register', [RegisterController::class, 'register']);

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

