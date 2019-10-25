<?php
Route::name('ministry.')->prefix('ministry/')->group(function () {
    Route::put('social-link', 'MinistryController@saveSocialLink');
    Route::post('profile', 'MinistryController@updateProfile');
    Route::post('photo', 'MinistryController@updatePhoto');
    Route::post('password', 'MinistryController@updatePassword');
    Route::delete('/', 'MinistryController@deleteProfile');
});
