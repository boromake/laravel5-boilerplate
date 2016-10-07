@extends('layout.default_template')

@section('title', 'Register')

@section('content')

<div class="row column">
	<h1>Register</h1>
	@include('_partials.errors')
</div>


{{Form::open(['url' => route('account::register.post')])}}

	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::label('email', 'E-Mail')}}
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
			{{Form::label('password_confirmation', 'Confirm Password')}}
			{{Form::password('password_confirmation')}}
		</div>
	</div>
	<div class="row">
		<div class="columns small-12 large-4 end">
			{{Form::submit('Register', ['name' => 'submit_register','class' => 'button success'])}}
			Already a member?
			<a href="{{route('account::login')}}">Log In</a>
		</div>
	</div>
{{Form::close()}}

@endsection
