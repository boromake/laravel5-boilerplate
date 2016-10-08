@extends('layout.default_template')

@section('title', 'Laravel 5 Boilerplate')

{{-- add meta description --}}
@section('meta-description', 'Larevel 5 Boilerplate')

@section('content')

	<div class="row column">
		<p>
		Check out the wiki: <a href="https://github.com/boromake/laravel-5-boilerplate/wiki" target="_blank">https://github.com/boromake/laravel-5-boilerplate/wiki</a>
		</p>
		<p>
		Font Awesome test: @icon(thumbs-o-up la-lg)
		</p>
		<p>
		Image resizer and file system test. Do you see the thumbnail below?
		</p>
		<img src="{{asset('storage/' . \App\Classes\ImageResizer::fit('test', 'http://lorempixel.com/400/200/', 200, 0))}}" />
	</div>
@endsection

