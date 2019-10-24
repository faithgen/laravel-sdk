<?php
Route::namespace('FaithGen\SDK\Http\Controllers')->prefix(config('faithgen-sdk.prefix'))->group(function () {
    Route::prefix('auth/')->name('auth.')->group(function () {
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('forgot-password', 'AuthController@forgotPassword')->name('forgotPassword');
        Route::get('resend-activation', 'AuthController@resendActivation')->name('resendActivation')->middleware('auth:api');
        Route::delete('delete-account', 'AuthController@deleteAccount')->name('deleteAccount')->middleware('auth:api');
        Route::get('logout', 'AuthController@logout')->name('logout')->middleware('auth:api');
    });

    Route::middleware(['auth:api', 'ministry.activated'])->group(function () {
        Route::name('ministry.')->prefix('ministry/')->group(function () {
            Route::post('social-link', 'MinistryController@getSocialLink');
            Route::put('social-link', 'MinistryController@saveSocialLink');
            Route::get('profile', 'MinistryController@getProfile');
            Route::post('profile', 'MinistryController@updateProfile');
            Route::post('photo', 'MinistryController@updatePhoto');
            Route::post('password', 'MinistryController@updatePassword');
            Route::delete('/', 'MinistryController@deleteProfile');
        });
    });
});


