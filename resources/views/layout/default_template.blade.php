@extends('layout.page')

@push('css')
	{{-- add here --}}
@endpush

@push('scripts')
	{{--add here --}}
@endpush

{{-- Add any meta tags that should be included on every page that extends this template --}}
@push('meta')
	<meta name="robots" content="index, follow" />
@endpush


@section('nav')
	<div class="row column">
		<nav>
			<ul class="menu">
				<li><a href="#">One</a></li>
				<li><a href="#">Two</a></li>
				<li><a href="#">Three</a></li>
				<li><a href="#">Four</a></li>
			</ul>
		</nav>
	</div>
@endsection


@section('footer')
	<div class="row column">
		<footer>
			<div class="callout">
				Footer placeholder
			</div>
		</footer>
	</div>
@endsection


{{--
@push('before-closing-body')


@endpush
--}}