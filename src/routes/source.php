<?php

use FaithGen\SDK\Http\Controllers\MinistryController;
use FaithGen\SDK\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::name('ministry.')->prefix('ministry/')->group(function () {
    Route::get('users', [MinistryController::class, 'users']);
    Route::put('social-link', [MinistryController::class, 'saveSocialLink']);
    Route::post('profile', [MinistryController::class, 'updateProfile']);
    Route::post('photo', [MinistryController::class, 'updatePhoto']);
    Route::post('password', [MinistryController::class, 'updatePassword']);
    Route::post('users/toggle-activity', [MinistryController::class, 'toggleActivity']);
    Route::delete('/', [MinistryController::class, 'deleteProfile']);
});

Route::name('modules.')
    ->prefix('modules/')
    ->group(function () {
        Route::get('', [ModuleController::class, 'index']);
        Route::post('', [ModuleController::class, 'addModules']);
    });
