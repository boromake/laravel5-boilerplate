@extends('layout.page')

@section('title', '403 - Not Authorized')

@section('content')

<div class="row column">
	<h1>403 - Not Authorized</h1>

	<div class="callout alert">
	{{!empty($exception->getMessage()) ?  $exception->getMessage() :  'Sorry, you are not authorized to be on this page.'}}
	</div>
</div>
@endsection

