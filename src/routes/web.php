<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register-top');
});

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/user-login', function () {
    return view('user-login');
})->name('user-login');

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('forgot-password');


Route::get('/user-register', function () {
    return view('user-register');
})->name('user-register');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

