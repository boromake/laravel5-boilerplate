<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
	realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
	Illuminate\Contracts\Http\Kernel::class,
	App\Http\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Console\Kernel::class,
	App\Console\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Debug\ExceptionHandler::class,
	App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Custom Monolog settings
|--------------------------------------------------------------------------
*/
$app->configureMonologUsing(function($monolog) use ($app)
{
	$default_formatter = new Monolog\Formatter\LineFormatter(null, null, true, true);

	//Preprocessors
	$monolog->pushProcessor(new \Monolog\Processor\WebProcessor());
	$monolog->pushProcessor(new \Monolog\Processor\GitProcessor());
	$monolog->pushProcessor(new \Monolog\Processor\UidProcessor());
	$monolog->pushProcessor(new \Monolog\Processor\IntrospectionProcessor(
		\Monolog\Logger::DEBUG,
		['Illuminate\Log\Writer'], //Tell processor which functions it should skip in the stack trace
		1 //This is very important. If you look at the IntrospectionProcessor code, it is
	//off by 1 when it decides which index to extract from the stack trace. This is
	//probably hacky, but adding an offset of 1 fixes the issue.
	));
	$monolog->pushProcessor(new \App\Classes\Monolog\UserProcessor());


	if(config('app.enable_file_logging'))
	{
		// File handler for debug+
		$monolog->pushHandler($debug_stream_handler = new \Monolog\Handler\RotatingFileHandler(storage_path('logs/laravel_debug.log'), config('app.log_max_files'), \Monolog\Logger::DEBUG, true));
		$debug_stream_handler->setFormatter($default_formatter);

		// File handler for error+
		$monolog->pushHandler($error_stream_handler = new \Monolog\Handler\RotatingFileHandler(storage_path('logs/laravel_error.log'), config('app.log_max_files'), \Monolog\Logger::ERROR, false));
		$error_stream_handler->setFormatter($default_formatter);
	}

	if(config('app.enable_database_logging'))
	{
		// set log level based on environment
		$log_level = config('app.env') == 'production' ? \Monolog\Logger::INFO : \Monolog\Logger::DEBUG;

		// MySql handler for debug+
		$monolog->pushHandler($mysql_handler = new \App\Classes\Monolog\MySqlHandler(new App\Models\Logging\Log(), $log_level, true));
		$mysql_handler->setFormatter(new Monolog\Formatter\JsonFormatter());
	}

	if(config('app.enable_email_logging'))
	{
		// Mail handler for error+
		$monolog->pushHandler($mail_handler = new \App\Classes\Monolog\MailgunHandler(config('services.mailgun.secret'), \Monolog\Logger::ERROR, true));
		$mail_handler->setFormatter(new Monolog\Formatter\HtmlFormatter());
	}
});


/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
