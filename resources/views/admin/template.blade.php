@extends('layout.page')

{{-- Add any css files that should be included on every ADMIN web page --}}
@push('css')
	{{-- add here --}}
@endpush

{{-- Add any js that should be included on every ADMIN web page --}}
@push('scripts')
	{{-- add here --}}
@endpush

@section('nav')
	<div class="row column">
		<nav>
			<ul class="menu">
				<li><a href="{{route('admin::landing')}}">@icon(home fa-lg) Admin Home</a></li>
			</ul>
		</nav>
	</div>
@endsection