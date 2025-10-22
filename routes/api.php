<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('/v1/auth')->middleware('throttle:auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('auth.verify-email');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});

/**
 * Example usage of permission and roles middleware
 */
//  Route::middleware(['role:admin', 'permission:view_users'])->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//  });