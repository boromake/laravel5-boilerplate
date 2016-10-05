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
	<nav>
		Nav placeholder
	</nav>
@endsection


@section('footer')
	<footer>
		Footer placeholder
	</footer>
@endsection


{{--
@push('before-closing-body')


@endpush
--}}