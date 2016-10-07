@extends('layout.default_template')

@section('title', 'Log In')

@section('content')

<div class="row column">
	<h1>Log In</h1>
	@include('_partials.errors')
</div>

{{Form::open(['url' => route('account::login.post')])}}
	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::label('email', 'E-Mail Address')}}
			{{Form::text('email')}}
		</div>
	</div>
	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::label('password', 'Password')}}
			{{Form::password('password')}}
		</div>
	</div>
	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::checkbox('remember')}}
			{{Form::label('remember', 'Remember Me')}}
		</div>
	</div>
	<div class="row">
		<div class="columns small-12 large-4 end">
			<button type="submit" name="submit_login" class="button success">
				@icon(sign-in) Login
			</button>
			<a href="{{ route('account::reset_password') }}">
				Forgot Your Password?
			</a>
		</div>
	</div>
{{Form::close()}}

@endsection
