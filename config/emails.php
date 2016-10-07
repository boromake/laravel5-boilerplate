<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Email Aliases
	|--------------------------------------------------------------------------
	|
	| Email aliases when sending emails
	|
	| Make sure to set the default to the actual emails
	| (on dev they will get re-written, so you don't have to worry about that)
	|
	*/
	'webmaster' => env('EMAILS_WEBMASTER', 'laravel5boilerplate@mailinator.com'),

	'testing' => [
		'admin' => 'admin@gmail.com',
		'registered' => 'registered@gmail.com',
	],
];
