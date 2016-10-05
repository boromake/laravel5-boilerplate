const elixir = require('laravel-elixir');

require('./elixir-extensions');

var compiledCssBaseDir = 'public/css/compiled/';
var mashedJSBaseDir = 'public/js/mashed/';

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
	mix.copy('bower_components/foundation-sites/dist/foundation.min.js', 'public/build/js/vendor/foundation.min.js');

	mix.copy('bower_components/jquery/dist/jquery.min.js', 'public/build/js/vendor/jquery.min.js');
	mix.copy('bower_components/jquery/dist/jquery.min.map', 'public/build/js/vendor/jquery.min.map');

	mix.copy('bower_components/sweetalert2/dist/sweetalert2.min.js', 'public/build/js/vendor/sweetalert2.min.js');
	mix.copy('bower_components/sweetalert2/dist/sweetalert2.css', 'public/build/css/vendor/sweetalert2.css');

	mix.copy('resources/assets/css/vendors/font-awesome.min.css', 'public/build/css/vendor/font-awesome.min.css');

	/*
	 |--------------------------------------------------------------------------
	 | Compile/mash SASS files into CSS files
	 |--------------------------------------------------------------------------
	 |
	 | Compile the source SASS files into CSS, and save to /public/css/compiled/*
	 |
	 */

	// foundation.css
	// (this is Foundation 6 + Motion UI)
	mix.sass(
		'vendors/foundation/foundation-sites-bootstrap.scss',
		compiledCssBaseDir + 'vendors/foundation.css', //save as
		null,
		{
			includePaths:
				[
					'bower_components/foundation-sites/scss/',
					'bower_components/motion-ui/'
				]
		}
	);

	// global.css
	mix.sass(
		'global.scss',
		compiledCssBaseDir + 'global.css', //save as
		null,
		{
			includePaths: 'bower_components/foundation-sites/scss/'
		}
	);


	/*
	 |--------------------------------------------------------------------------
	 | Mash Javascript
	 |--------------------------------------------------------------------------
	 |
	 | Mash JS files, and save to /public/js/mashed/*
	 |
	 */

	// global.js
	mix.scripts(
		'global.js',
		mashedJSBaseDir + 'global.js', //save as
		'resources/assets/js' //source directory
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
	 | included into this project via Bower.
	 |
	 */
	mix.version(
		[
			compiledCssBaseDir + 'vendors/foundation.css',
			compiledCssBaseDir + 'global.css',
			mashedJSBaseDir + 'global.js'
		]
	);

});
