<?php

use Illuminate\Support\Facades\Route;
use FaithGen\SDK\Http\Controllers\AuthController;

Route::prefix('auth/')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::get('resend-activation', [AuthController::class, 'resendActivation'])->name('resendActivation')->middleware('auth:api');
    Route::delete('delete-account', [AuthController::class, 'deleteAccount'])->name('deleteAccount')->middleware('auth:api');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:api');
});
