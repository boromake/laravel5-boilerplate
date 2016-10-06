<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use Carbon\Carbon;

class LoginHistory extends BaseModel
{
	protected $table = 'user_login_history';

	/**
	 * Add all database fields you want to make mass assignable
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'ip',
		'used_login_cookie',
		'minutes_since_last_login',
		'server_ip',
		'server_name',
	];

	protected $rules = [
		'user_id' => 'required',
	];

	protected $casts = [
		'minutes_since_last_login' => 'integer',
		'used_login_cookie' => 'boolean',
	];



	#region Public helper methods

	/**
	 * Return, in a human readable format, the approximate amount of time it has been
	 * since this users's last login.
	 *
	 * Basically this method takes the 'minutes_since_last_login' value, and turns it
	 * into a human-readable time span. (e.g. 122 minutes => 2 hours)
	 *
	 * @return string
	 */
	public function human_readable_previous_login()
	{
		return Carbon::now()->subMinutes($this->minutes_since_last_login)->diffForHumans();
	}

	#endregion


	#region Relationships

	/**
	 * Get the User referenced by this event
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\Users\User', 'user_id', 'uuid');
	}


	#endregion
}