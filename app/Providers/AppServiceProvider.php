<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/*
		|--------------------------------------------------------------------------
		| Custom Blade Directives
		|--------------------------------------------------------------------------
		*/

		/**
		 * Create a new @icon Blade directive
		 *
		 * Tip: Whatever you pass for $icon_name is put inside the 'class' attribute, so you can
		 * pass css classes as well.
		 *
		 * @uses @icon(trash-o fa-lg) No quotes needed to denote string
		 */
		\Blade::directive('icon', function($icon_name)
		{
			// need to strip paranthesis because of weird behavior
			// https://github.com/laravel/framework/issues/7349
			$icon_name = trim($icon_name, '()');

			return "<?php echo \"<i class=\\\"fa fa-$icon_name\\\" aria-hidden=\\\"true\\\"></i>\" ?>";
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
