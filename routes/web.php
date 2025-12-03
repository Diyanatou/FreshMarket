<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Welcome');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', [AuthController::class, 'login'])->name('login.post');
