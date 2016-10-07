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

Route::group(['as' => 'account::', 'prefix' => 'account', 'namespace' => 'Auth', 'middleware' => 'web'], function () {
	// Log-in / Log-out
	Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
	Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);

	// Registration
	Route::get('register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
	Route::post('register', ['as' => 'register.post', 'uses' => 'RegisterController@register']);
});

/*
|--------------------------------------------------------------------------
| "Password" Routes
|--------------------------------------------------------------------------
*/
Route::group(['as' => 'password::', 'prefix' => 'password', 'namespace' => 'Auth', 'middleware' => 'web'], function () {
	// Forgot password
	Route::get('forgot', ['as' => 'forgot', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
	Route::post('forgot', ['as' => 'forgot.post', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);

	// Reset password
	Route::get('reset/{token}', ['as' => 'reset', 'uses' => 'ResetPasswordController@showResetForm']);
	Route::post('reset', ['as' => 'reset.post', 'uses' => 'ResetPasswordController@reset']);
});
