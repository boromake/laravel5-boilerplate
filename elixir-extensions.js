var gulp = require('gulp');
var shell = require('gulp-shell');
var Elixir = require('laravel-elixir');

var Task = Elixir.Task;

/**
 * Function env()
 *
 * New function to copy .env.local to .env
 */
Elixir.extend('env', function() {

	new Task('env', function() {
		return gulp.src('').pipe(shell('cp .env.local .env'));
	});
});