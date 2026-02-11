<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/hotels', [AuthController::class, 'hotels']);
