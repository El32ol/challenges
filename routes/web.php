<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/challenges', function () {
    return view('login');
});

Route::post('/login/check', [App\Http\Controllers\LoginController::class, 'check'])->name('login.check');


Route::prefix('dashboard')->middleware(['guest'])->group(function () {

    Route::get('/register', [AuthController::class, 'getRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login' , [AuthController::class, 'getLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

});
Route::prefix('dashboard')->middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});

