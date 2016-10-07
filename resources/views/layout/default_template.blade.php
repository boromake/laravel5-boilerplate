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
				@if(auth()->check())
					<li>
						Welcome, @icon(user) <strong>{{auth()->user()->email}}</strong>!
						<a href="{{route('account::logout')}}">@icon(sign-out) Log-Out</a>
					</li>
				@else
					<li><a href="{{route('account::register')}}">Register</a></li>
					<li><a href="{{route('account::login')}}">@icon(sign-in) Log-In</a></li>
				@endif
			</ul>
		</nav>
	</div>
@endsection


@section('footer')
	<div class="row column">
		<footer>
			<div class="callout text-center">
				Footer placeholder
			</div>
		</footer>
	</div>
@endsection


{{--
@push('before-closing-body')


@endpush
--}}