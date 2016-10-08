@extends('admin.template')

@section('title', 'View Log Details')

@push('scripts')
	<script src="{{ asset('build/js/vendors/jquery.jsonview.min.js') }}"></script>
@endpush

@push('css')
	<link rel="stylesheet" href="{{ asset('build/css/vendors/jquery.jsonview.min.css') }}">
@endpush

@section('content')

<div class="row column">
	<h1>View Log Details</h1>

	<p>[ <a href="{{route('admin::logs::general')}}">Back to all logs</a> ]</p>


	<table class="hover">
		<tbody>
			@foreach($log_details as $key => $value)
				@if($key != 'formatted_message')
					<tr>
						<td><b>{{ $key }}</b></td>
						<td>{{ is_null($value) ? '&nbsp;' : $value }}</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>

	<div id="json-collapsed"></div>

</div>

@endsection


@push('before-closing-body')
	<script type="text/javascript">
		var json = <?php echo $log_details['formatted_message']; ?>;
		$(function() {
			$("#json-collapsed").JSONView(json, { collapsed: true, nl2br: false, recursive_collapser: true });
		});
	</script>
@endpush
