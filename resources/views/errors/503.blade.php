@extends('layouts.page')

@section('title', '503 - Service Unavailable')

@section('content')

	<h1>503 - Service Unavailable</h1>

	<div>
		{{!empty($exception->getMessage()) ?  $exception->getMessage() :  'Sorry, this page is temporarily unavailable. Please wait a little, and then try again.'}}
	</div>

@endsection