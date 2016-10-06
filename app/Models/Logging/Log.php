<?php

namespace App\Models\Logging;

use App\Models\BaseModel;

class Log extends BaseModel
{
	/**
	 * The name of the corresponding database table
	 * @var string
	 */
	protected $table = 'logs_logging';

	/**
	 * Add any fields that should be mutated to dates.
	 * 'created_at', 'updated_at', and 'deleted_at' will automaticallly be mutated, so you don't need to add them.
	 * @var array
	 */
	protected $dates = [
		'timestamp'
	];

	/**
	 * Add all database fields you want to make mass assignable
	 * @var array
	 */
	protected $fillable = [
		'uid',
		'channel',
		'level_name',
		'level',
		'status_code',
		'message',
		'timestamp',
		'user_id',
		'user_email',
		'request_method',
		'uri',
		'ip',
		'server',
		'git_branch',
		'git_commit',
		'error_file',
		'error_line',
		'call_class',
		'call_function',
		'call_file',
		'call_line',
		'formatted_message',
	];

	/**
	 * Add validation rules
	 * @var array
	 * @see https://github.com/dwightwatson/validating
	 * @see https://laravel.com/docs/5.3/validation#available-validation-rules
	 */
	protected $rules = [
		'channel' => 'required|string',
		'level_name' => 'required|string',
		'level' => 'required|numeric',
		'message' => 'required|string',
		'timestamp' => 'required|date',
	];

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