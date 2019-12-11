<?php

use FaithGen\SDK\Http\Controllers\MinistryController;
use Illuminate\Support\Facades\Route;

Route::name('ministry.')->prefix('ministry/')->group(function () {
    Route::post('social-link', [MinistryController::class, 'getSocialLink']);
    Route::get('profile', [MinistryController::class, 'getProfile']);
    Route::get('account-type', [MinistryController::class, 'accountType']);
});
