const elixir = require('laravel-elixir');

require('./elixir-extensions');
require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// Turn off sourcemap files
// elixir.config.sourcemaps = false;

elixir(mix => {

	/*
	 |--------------------------------------------------------------------------
	 | Create/Refresh the .env file
	 |--------------------------------------------------------------------------
	 |
	 | ONLY RUN IN DEV
	 | Create/refresh the .env file by copying .env.local -> .env
	 |
	 */
	if(!elixir.config.production) {
		mix.env();
	}

	mix.sass('app.scss')
	   .webpack('app.js');
});
