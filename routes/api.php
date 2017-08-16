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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'RegisterController@register');
Route::post('/register/vendor', 'RegisterController@vendor')->name('vendor.register');
Route::post('/token', 'LoginController@check_token');
Route::post('/reset_auth', 'LoginController@remove_cookie');
Route::post('/profile', 'LoginController@get_profile')->middleware(['token']);
Route::post('/login', 'LoginController@login');