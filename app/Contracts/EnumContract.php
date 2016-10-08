<?php

namespace App\Contracts;

interface EnumContract
{
	/**
	 * Return the label/name for a specific enum
	 *
	 * @param int $typeValue
	 * @return string
	 */
	public static function label($typeValue);

	/**
	 * Return all the labels
	 *
	 * @return array
	 */
	public static function labels();

	/**
	 * Return all the keys (const values)
	 *
	 * @return array
	 */
	public static function keys();
}
