const elixir = require('laravel-elixir');

require('./elixir-extensions');
require('laravel-elixir-vue-2');

var compiledCssBaseDir = 'public/css/compiled/';
var compiledJSBaseDir = 'public/js/compiled/';

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
	 | Create/refresh the .env file
	 |--------------------------------------------------------------------------
	 |
	 | ONLY RUN IN DEV
	 | Create/refresh the .env file by copying .env.local -> .env
	 |
	 */
	if(!elixir.config.production) {
		mix.env();
	}

	/*
	 |--------------------------------------------------------------------------
	 | Copy Files
	 |--------------------------------------------------------------------------
	 |
	 | Copy any css/js files that we will be using as-is.
	 |
	 | These files have already been mashed/minified by the provider, and have been
	 | included into this project via Bower.
	 |
	 */
	mix.copy('bower_components/jquery/dist/jquery.min.js', 'public/build/js/vendor/jquery.min.js');
	mix.copy('bower_components/jquery/dist/jquery.min.map', 'public/build/js/vendor/jquery.min.map');

	mix.copy('bower_components/sweetalert2/dist/sweetalert2.min.js', 'public/build/js/vendor/sweetalert2.min.js');
	mix.copy('bower_components/sweetalert2/dist/sweetalert2.css', 'public/build/css/vendor/sweetalert2.css');



	/*
	 |--------------------------------------------------------------------------
	 | Compile/mash SASS files into CSS files
	 |--------------------------------------------------------------------------
	 |
	 | Compile the source SASS files into CSS, and save to /public/css/compiled/*
	 |
	 */

	// global.css
	mix.sass('global.scss',
		compiledCssBaseDir + 'global.css' //save as
	);

	/*
	 |--------------------------------------------------------------------------
	 | Mash Javascript
	 |--------------------------------------------------------------------------
	 |
	 | Mash JS files, and save to /public/js/mashed/*
	 |
	 */
	mix.webpack('global.js',
		compiledJSBaseDir + 'global.js'
	);



	/*
	 |--------------------------------------------------------------------------
	 | Version files
	 |--------------------------------------------------------------------------
	 |
	 | Assumes source files are in /public/*
	 |
	 | Saves to /public/build/*
	 |
	 | These files have already been mashed/minified by the provider, and have been
	 | inclued into this project via Bower.
	 |
	 */
	mix.version(
		[
			compiledCssBaseDir + 'global.css',
			compiledJSBaseDir + 'global.js'
		]
	);

});
