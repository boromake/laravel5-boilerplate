@extends('admin.template')

@section('title', 'Login History')

@section('content')

<div class="row column">
	<h1>Login History @if(!is_null($filtered_user))for {{$filtered_user->email}}@endif</h1>

	@if(!is_null($filtered_user))
		<p>[<a href="{{route('admin::users::login_history')}}">Show all users again</a>]</p>
	@endif

	<table class="hover">
		<thead>
			<tr>
				<th>Login Date</th>
				<th>User</th>
				<th>Previous Login</th>
				<th>Method</th>
				<th>User IP</th>
				<th>Server IP</th>
			</tr>
		</thead>
		<tbody>

		@foreach ($login_history as $login)
			<tr>
				<td>{{ is_null($login->created_at) ? '&nbsp;' : $login->created_at->format(config('app.datetime_format')) }}</td>
				<td>@if(is_null($login->user))&nbsp;@else <a href="{{route('admin::users::login_history', ['id' => $login->user->id])}}">{{$login->user->email}}</a> @endif</td>
				<td>{{ is_null($login->minutes_since_last_login) ? 'First login!' : $login->human_readable_previous_login() }}</td>
				<td>{{ empty($login->used_login_cookie) ? 'form' : 'cookie' }}</td>
				<td>{{ is_null($login->ip) ? '&nbsp;' : $login->ip }}</td>
				<td>{{ is_null($login->server_ip) ? '&nbsp;' : $login->server_ip }}</td>
			</tr>
		@endforeach

		</tbody>
	</table>

</div>
@endsection
