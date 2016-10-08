<?php

namespace App\Http\Middleware;

use Closure;

class VerifyRole
{
	/**
	 * Verify the user has authorization to view the page.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  array $roles array of \App\Enums\UserAccountTypes
	 * @return mixed
	 */
	public function handle($request, Closure $next, ...$roles)
	{
		if(auth()->check())
		{
			// make sure we have an array
			$roles = is_array($roles) ? $roles : array($roles);

			// they just need access as any one of the $roles
			foreach($roles as $role)
			{
				if(auth()->user()->has_access($role))
				{
					return $next($request);
				}
			}

			abort(403);
		}
		else
		{
			if ($request->ajax() || $request->wantsJson())
			{
				return response('Forbidden.', 403);
			}
			else
			{
				abort(403);
			}
		}
	}
}