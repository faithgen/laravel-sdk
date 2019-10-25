<?php
Route::name('ministry.')->prefix('ministry/')->group(function () {
    Route::post('social-link', 'MinistryController@getSocialLink');
    Route::get('profile', 'MinistryController@getProfile');
});

