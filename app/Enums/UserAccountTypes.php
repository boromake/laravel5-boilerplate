<?php

namespace App\Enums;


use App\Contracts\EnumContract;

class UserAccountTypes implements EnumContract
{
	const UNKNOWN               = 0;
	const OWNER                 = 1; // highest access level (should be reserved for the dev/owner of the site)
	const ADMIN                 = 2;
	const MODERATOR             = 3;
	const PAID                  = 4; // paid user
	const REGISTERED            = 5; // "normal" user

	private static $typeLabels = array(
		self::UNKNOWN              => 'Unknown',
		self::OWNER                => 'Owner',
		self::ADMIN                => 'Admin',
		self::MODERATOR            => 'Moderator',
		self::PAID                 => 'Paid Member',
		self::REGISTERED           => 'Member',
	);

	/**
	 * @inheritdoc
	 */
	public static function label($typeValue)
	{
		return isset( static::$typeLabels[$typeValue] ) ? static::$typeLabels[$typeValue] : '';
	}

	/**
	 * @inheritdoc
	 */
	public static function labels()
	{
		return static::$typeLabels;
	}

	/**
	 * @inheritdoc
	 */
	public static function keys()
	{
		return array_keys( static::$typeLabels );
	}
}