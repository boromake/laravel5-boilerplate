@extends('admin.template')

@section('title', 'View Users')

@section('content')

<div class="row column">
	<h1>View Users</h1>

	<form action="{{route('admin::users')}}" method="GET">


		<div class="callout">
			<div class="row">
			<div class="columns large-2">
				<label for="account_type" class="middle">Account Type</label>
			</div>
			<div class="columns large-2">
				{{ Form::select('account_type', \App\Enums\UserAccountTypes::labels(), array_get($form_data, 'account_type', App\Enums\UserAccountTypes::REGISTERED), ['placeholder' => 'Any']) }}
			</div>
			<div class="columns large-1">
				<label for="is_active" class="middle">Status</label>
			</div>
			<div class="columns large-2">
				{{ Form::select('is_active', array('1' => 'All users ', '0' => 'Only active'), array_get($form_data, 'is_active', 0)) }}
			</div>
			<div class="columns large-1">
				<label for="order_by" class="middle">Order By</label>
			</div>
			<div class="columns large-2">
				{{ Form::select('sort_by', array('last_login' => 'Last Login', 'email' => 'Email'), array_get($form_data, 'sort_by', '')) }}
			</div>
			<div class="columns large-1">
				{{ Form::select('sort_direction', array('desc' => 'Desc', 'asc' => 'Asc'), array_get($form_data, 'sort_direction', '')) }}
			</div>
			<div class="columns large-1 end">
				<button type="submit" name="submit" class="button success" value="submit">
					Go
				</button>
			</div>
			</div>
		</div>
	</form>

	<p>Results: {{$users->count()}}</p>

	<table class="hover">
		<thead>
			<tr>
				<th>Last Login</th>
				<th>User</th>
				<th>Account Type</th>
				<th>Status</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ is_null($user->last_login) ? '&nbsp;' : $user->last_login->format(config('app.datetime_format')) }}</td>
					<td>{{ is_null($user->email) ? '&nbsp;' : $user->email }}</td>
					<td>{{ is_null($user->account_type) ? '&nbsp;' : \App\Enums\UserAccountTypes::label($user->account_type) }}</td>
					<td>@if(is_null($user->deleted_at)) Active @else Inactive (deleted) @endif</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</div>
@endsection
