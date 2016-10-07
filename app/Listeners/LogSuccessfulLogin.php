<?php

namespace App\Listeners;

use Request;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use App\Models\Users\LoginHistory;

class LogSuccessfulLogin
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * User $event->user
	 * bool $event->remember Was the "remember me" cookie used to auto-login this user
	 *
	 * @param  Login  $event
	 * @return void
	 */
	public function handle(Login $event)
	{
		// compute minutes since last login
		$last_login = $event->user->login_history()->orderBy('created_at', 'desc')->first();
		$minutes_since_last_login = is_null($last_login) ? 0 : $last_login->created_at->diffInMinutes(Carbon::now());

		// figure out if user was automatically logged-in via the cookie
		// this is a little confusing because $event->remember is used differently
		//
		// on one hand, it is set to true when the user is genuinely logged in via the
		// cookie (see line 146 of the user() function in /vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php
		//
		// on the other hand, it is also set to true if the user selects the option to "remember me" from
		// the login page.
		//
		// so to figure out if the user was actually logged in via the cookie, we need to check that
		// $event->remember is true AND the request isn't coming from the login page (or anywhere that
		// has the "remember me" checkbox)
		$used_login_cookie = $event->remember && (Request::route()->getName() != 'account::login.post');

		LoginHistory::create([
			'user_id' => $event->user->uuid,
			'ip' => Request::ip(),
			'used_login_cookie' => $used_login_cookie,
			'minutes_since_last_login' => $minutes_since_last_login,
			'server_ip' => Request::server('SERVER_ADDR'),
			'server_name' => Request::server('SERVER_NAME'),
		]);
	}
}
