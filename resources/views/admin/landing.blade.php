@extends('admin.template')

@section('title', 'Admin section')

@section('content')

<div class="row column">
	<h1>Admin Dashboard</h1>
</div>

<div class="row">
	<div class="columns small-12 large-4">
		<h5>Users</h5>
		<ul>
			<li><a href="{{route('admin::users')}}">View Users</a></li>
			<li><a href="{{route('admin::users::login_history')}}">User Login History</a></li>
		</ul>
	</div>
</div>


@endsection