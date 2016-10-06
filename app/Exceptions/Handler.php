<?php

namespace App\Exceptions;

use Psr\Log\LoggerInterface;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		//\Symfony\Component\HttpKernel\Exception\HttpException::class, // I want to know this
		//\Illuminate\Database\Eloquent\ModelNotFoundException::class, //  I think I want to know of these
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		//Leaving this in for reference
		//Out-of-the-box this method simply called up to the parent method
		//parent::report($e);

		if($this->shouldReport($e))
		{
			try
			{
				$logger = $this->container->make(LoggerInterface::class);
			}
			catch (Exception $ex)
			{
				throw $e; // throw the original exception
			}

			$status_code = ($e instanceof \ErrorException) ? 500 :
				(($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) ? $e->getStatusCode() : null );

			$logger->error($e->getMessage(), [
				'header' => \Request::header(),
				'input' => \Request::all(),
				'cookie' => \Request::cookie(),
				'server' => \Request::server(),
				'session' => \Request::hasSession() ? \Request::session()->all() : array(),
				'exception' => array(
					'status_code' => $status_code,
					'message' => $e->getMessage(),
					'code' => $e->getCode(),
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'trace' => $e->getTrace(),
				),
			]);
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		// custom error message for 500 errors
		// always show it on production
		// show it in other environments if app.debug is false
		if ($e instanceof \ErrorException && view()->exists('errors.500') && (!config('app.debug') || app()->environment() == 'production'))
		{
			return response()->view('errors.500', ['exception' => $e]);
		}
		else
		{
			// let default Laravel code handle everything else
			return parent::render($request, $e);
		}
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Auth\AuthenticationException  $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}
}
