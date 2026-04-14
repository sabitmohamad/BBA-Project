<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/dashboard', 'dashboard')->name('web.dashboard');

Route::view('/login', 'auth.login')->name('web.login');
Route::view('/register', 'auth.register')->name('web.register');
