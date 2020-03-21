<?php

use FaithGen\SDK\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    //->middleware('auth:api')
    ->group(function () {
        Route::post('register', [UsersController::class, 'register'])->name('users.register');
        Route::post('update', [UsersController::class, 'update']);
        Route::post('login', [UsersController::class, 'login']);
        Route::delete('', [UsersController::class, 'deleteUserAccount']);
        Route::get('user', [UsersController::class, 'getUser']);
    });
