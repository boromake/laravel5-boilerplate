{{--
- This is the master template for EVERY "page" template
- Every "page" on the site will inherit from this template at some point in the chain
- No page/view should extend/reference this master template directly
--}}
@extends('layout.master')

{{-- Add any css files that should be included on EVERY web page --}}
@push('css')
<link rel="stylesheet" href="{{ asset('/build/css/vendor/sweetalert2.css') }}">
@endpush

{{-- Add any js that should be included on EVERY web page --}}
@push('scripts')
<script src="{{asset('/build/js/vendor/sweetalert2.min.js')}}"></script>
@endpush

@section('body')

	{{--
	 HEADER
	 --}}
	<div class="row column">
		<div class="callout text-center">
			<header>
				<h1>Laravel 5 Boilerplate</h1>
			</header>
		</div>
	</div>

	{{--
	 NAVIGATION BAR
	 --}}
	@yield('nav')

	{{--
	 CONTENT
	 --}}
	@yield('content')

	{{--
	FOOTER
	--}}
	@section('footer')

	@show

@endsection {{-- end body --}}


@push('before-closing-body')
	{{-- SweetAlert module --}}
	@include('sweet::alert')
@endpush