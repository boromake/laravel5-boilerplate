<?php

namespace App\Classes\Monolog;

/**
 * Adds user info (if available) into records
 */
class UserProcessor
{
	public function __invoke(array $record)
	{
		$record['extra']['user'] = \Auth::check() ? array_only(\Auth::user()->toArray(), ['uuid', 'email']) : array();

		return $record;
	}

}
