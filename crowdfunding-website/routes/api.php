<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function () {
    Route::post('/register', 'RegisterController');
    Route::post('/verification', 'VerificationController');
    Route::post('/regenerate', 'RegenerateController');
    Route::post('/update-password', 'AuthController@update_password')->middleware('email-verify');
    Route::post('/login', 'LoginController')->middleware('email-verify');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/get-profile', 'ProfileController@get_profile');
    Route::post('/update-profile', 'ProfileController@update_profile');
});
