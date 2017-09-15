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
Route::post('/profile', 'ProfileController@get_profile')->middleware(['token']);
Route::put('/profile/edit', 'ProfileController@update')->middleware(['token']);
Route::put('/profile/driverlicense/edit', 'ProfileController@driver_license_update')->middleware(['token']);
Route::post('/user/document/upload', 'ProfileController@upload')->middleware(['token']);
Route::post('/login', 'LoginController@login');
Route::get('/cars', 'CarController@show');
Route::get('/cars/{cid}', 'CarController@detail');
Route::post('/cars/{cid}/book', 'BookingController@index')->middleware(['token']);
Route::post('/book', 'BookingController@book')->middleware(['token']);
Route::post('/book/history', 'BookingController@history')->middleware(['token']);
Route::post('/booking/{ohid}/pay', 'BookingController@pay')->middleware(['token']);
Route::post('/booking/{ohid}/cancel', 'BookingController@cancel')->middleware(['token']);
Route::post('/contact-us', 'ContactUsController@create');
Route::post('/register-newsletter', 'NewsletterController@register');

Route::get('/img/cars/{cid}', 'CarController@image');
Route::get('/img/cars/{cid}/{name}', 'CarController@image_by_name');

Route::post('/admin/cars', 'Admin\CarController@show');
Route::post('/admin/cars/{cid}/picture/upload', 'Admin\CarController@upload');
Route::post('/admin/brands', 'Admin\CarController@brands');
Route::post('/admin/cars/create', 'Admin\CarController@create');
Route::post('/admin/cars/show/{cid}', 'Admin\CarController@single');
Route::post('/admin/orders', 'Admin\OrderController@show');
Route::post('/admin/messages', 'Admin\ContactUsController@show');
Route::post('/admin/newsletter-emails', 'Admin\ContactUsController@show');
Route::post('/admin/users', 'Admin\UserController@show');
Route::post('/admin/admins', 'Admin\AdminController@show');