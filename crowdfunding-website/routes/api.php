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
    Route::post('/logout', 'LogoutController')->middleware('auth:api');
    Route::post('/check-token', 'CheckTokenController')->middleware('auth:api');
    Route::get('/social/{provider}', 'SocialiteController@redirectToProvider');
    Route::get('/social/{provider}/callback', 'SocialiteController@handleProviderCallback');
});

Route::middleware(['api', 'auth:api'])->group(function () {
    Route::get('/get-profile', 'ProfileController@get_profile');
    Route::post('/update-profile', 'ProfileController@update_profile');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'campaign'
], function () {
    Route::get('random/{count}', 'CampaignController@random');
    Route::post('store', 'CampaignController@store');
    Route::get('/', 'CampaignController@index');
    Route::get('/{id}', 'CampaignController@detail');
    Route::get('/search/{keyword}', 'CampaignController@search');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog'
], function () {
    Route::get('random/{count}', 'BlogController@random');
    Route::post('store', 'BlogController@store');
    Route::get('/', 'BlogController@index');
    Route::get('/{id}', 'BlogController@detail');
});
