<?php

use FaithGen\SDK\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/')->namespace('FaithGen\SDK\Http\Controllers')->group(function () {
    Route::get('activate/{ministry}/{code}', [AuthController::class, 'activateAccount'])->name('activateAccount')->middleware('bindings');
});
