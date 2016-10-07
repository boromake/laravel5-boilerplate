<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*
|--------------------------------------------------------------------------
| "Public" Routes
|--------------------------------------------------------------------------
*/

Route::get('/', ['as' => 'homepage', function () {
	Alert::success('Sweet Alert is set up!', 'Success!')->persistent("Close");

	return view('homepage');
}]);



/*
|--------------------------------------------------------------------------
| "Account" Routes
|--------------------------------------------------------------------------
*/

Route::group(['as' => 'account::', 'prefix' => 'account', 'namespace' => 'Auth', 'middleware' => 'web'], function ()
{
	// Authentication Routes
	Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
	Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

	// Registration Routes
	Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
	Route::post('register', ['as' => 'register.post', 'uses' => 'RegisterController@register']);

	// Password Reset Routes
	Route::get('password/reset/{token?}', ['as' => 'reset_password', 'uses' => 'PasswordController@showResetForm']);
	Route::post('password/email', ['as' => 'password_email.post', 'uses' => 'PasswordController@sendResetLinkEmail']);
	Route::post('password/reset', ['as' => 'reset_password.post', 'uses' => 'PasswordController@reset']);
});
