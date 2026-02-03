<?php

use Illuminate\Support\Facades\Route;

Route::get('/challenges', function () {
    return view('login');
});

Route::post('/login/check', [App\Http\Controllers\LoginController::class, 'check'])->name('login.check');
