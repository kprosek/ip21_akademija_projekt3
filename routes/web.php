<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginProcess')->name('login-submit');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
