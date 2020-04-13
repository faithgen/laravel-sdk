<?php

use FaithGen\SDK\Http\Controllers\CommentController;
use FaithGen\SDK\Http\Controllers\ImageController;
use FaithGen\SDK\Http\Controllers\MinistryController;
use FaithGen\SDK\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::name('ministry.')->prefix('ministry/')->group(function () {
    Route::post('social-link', [MinistryController::class, 'getSocialLink']);
    Route::get('profile', [MinistryController::class, 'getProfile']);
    Route::get('account-type', [MinistryController::class, 'accountType']);
});

Route::name('images.')->prefix('images')->group(function () {
    Route::post('comment', [ImageController::class, 'comment']);
    Route::get('comments/{image}', [ImageController::class, 'comments']);
});

Route::prefix('reviews')
    ->group(function () {
        Route::post('', [ReviewController::class, 'sendReview']);
    });

if (! config('faithgen-sdk.source')) {
    Route::prefix('comments')
        ->group(function () {
            Route::post('presence', [CommentController::class, 'presenceRegister']);
            Route::post('typing', [CommentController::class, 'showTyping']);
        });
}
