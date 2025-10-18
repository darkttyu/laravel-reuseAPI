<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});