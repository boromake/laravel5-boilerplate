<?php

namespace App\Models\Logging;

use App\Models\BaseModel;

class Event extends BaseModel
{
	/**
	 * These event "ids" map to the database, so they CANNOT be changed!
	 */
	const EVENT_UNKNOWN             = 0;
	const EVENT_EMAIL_SENT          = 1;

	protected $table = 'logs_events';

	protected $fillable = [
		'user_id',
		'event_id',
		'description',
		'extra_info',
	];

	protected $rules = [
		'event_id' => 'required|integer',
		'description' => 'sometimes|max:150',
	];

	protected $casts = [
		'extra_info' => 'array',
	];

	#region Public Methods

	public static $event_types = [
		self::EVENT_UNKNOWN => 'Unknown',
		self::EVENT_EMAIL_SENT => 'Email Sent',
	];

	#endregion



	#region Accessors/Mutators

	// I am "overriding" the $casts functionality by creating Accessors
	// (Accessors are checked before the $casts array)
	// I want any json fields to return an empty array if the database value is empty or null.
	// Without these Accessors, empty or null json fields get returned as null

	public function getExtraInfoAttribute($value)
	{
		$result = json_decode($value, true);

		return empty($result) ? array() : $result;
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