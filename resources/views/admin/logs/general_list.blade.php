@extends('admin.template')

@section('title', 'View Logs')

@section('content')

<div class="row column">

	<h1>View Logs</h1>

	<form action="{{route('admin::logs::general')}}" method="GET">

		<div class="callout primary">
			<div class="row">
				<div class="columns large-1">
					<label for="account_type" class="middle">Level</label>
				</div>
				<div class="columns large-1">
					{{ Form::select('level', array_flip(Monolog\Logger::getLevels()), array_get($form_data, 'level', ''), ['placeholder' => 'Any']) }}
				</div>
				<div class="columns large-1">
					<label for="order_by">User Email</label>
				</div>
				<div class="columns large-3">
					{{ Form::text('user_email', array_get($form_data, 'user_email', '')) }}
				</div>
				<div class="columns large-1">
					<label for="order_by" class="middle">URI</label>
				</div>
				<div class="columns large-2 end">
					{{ Form::text('uri', array_get($form_data, 'uri', '')) }}
				</div>

			</div>
			<div class="row">
				<div class="columns large-2">
					{{ Form::checkbox('include_404', 1, array_get($form_data, 'include_404', 0)) }}
					Include 404's
				</div>
				<div class="columns large-1">
					<button type="submit" name="submit" class="button success" value="submit">
						Go
					</button>
				</div>
			</div>
		</div>
	</form>

	<p>Results: {{count($logs)}}</p>

	<table class="hover">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Time Stamp</th>
				<th>Level</th>
				<th>Status Code</th>
				<th>User Email</th>
				<th>Request Method</th>
				<th>Uri</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($logs as $log)
				<tr>
					<td><a href="{{route('admin::logs::general_detail', ['id' => $log->id])}}">@icon(search fa-lg)</a></td>
					<td>{{ is_null($log->timestamp) ? '&nbsp;' : $log->timestamp->format(config('app.datetime_format')) }}</td>
					<td>{{ empty($log->level_name) ? '&nbsp;' : $log->level_name }}</td>
					<td>{{ empty($log->status_code) ? '&nbsp;' : $log->status_code }}</td>
					<td>{{ empty($log->user_email) ? '&nbsp;' : $log->user_email }}</td>
					<td>{{ empty($log->request_method) ? '&nbsp;' : $log->request_method }}</td>
					<td>@if(empty($log->uri)) &nbsp; @else <a href="{{url($log->uri)}}" target="_blank">{{url($log->uri)}}@endif</a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="6">{{ empty($log->message) ? '&nbsp;' : $log->message }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection
