<?php
Route::prefix('auth/')->namespace('FaithGen\SDK\Http\Controllers')->group(function () {
    Route::get('activate/{ministry}/{code}', 'AuthController@activateAccount')->name('activateAccount');
});
