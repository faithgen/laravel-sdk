<?php
Route::prefix('auth/')->name('auth.')->group(function () {
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('forgot-password', 'AuthController@forgotPassword')->name('forgotPassword');
    Route::get('resend-activation', 'AuthController@resendActivation')->name('resendActivation')->middleware('auth:api');
    Route::delete('delete-account', 'AuthController@deleteAccount')->name('deleteAccount')->middleware('auth:api');
    Route::get('logout', 'AuthController@logout')->name('logout')->middleware('auth:api');
});