@extends('layout.default_template')

@section('title', 'Reset Password')

<!-- Main Content -->
@section('content')

<div class="row column">
	<h1>Forgot Password</h1>
	@include('_partials.errors')
</div>

{{-- If the forgot password link was successfully sent, a 'status' key will be set in the session --}}
@if(session('status'))
	<div class="row column">
		<div class="callout success">
			{{ session('status') }}
		</div>
	</div>
@else
	{{Form::open(['url' => route('password::forgot.post')])}}
	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::label('email', 'E-Mail')}}
			{{Form::text('email')}}
		</div>
	</div>
		<div class="row">
			<div class="columns small-12 large-4 end">
				<button type="submit" class="button success">
					@icon(envelope-o) Send Password Reset Link
				</button>
			</div>
		</div>
	{{Form::close()}}
@endif

@endsection