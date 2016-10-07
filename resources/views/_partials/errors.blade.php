{{--
\Illuminate\Support\ViewErrorBag $errors

$errors is a ViewErrorBag object, but to make visualization easier, if we pretend it was an array
it would be 3 levels deep and look like this:

Note:
If not explicitly set, the default bag_name will be 'default'
If not explicity set, there won't be a 'field_name'. It will just be a numbered index

Structure:
[
	'bag_name' => [
		'field_name' => [
			'error_message_1',
			'error_message_2',
			'etc',
			]
	]
]

Example:
[
	'default' => [
		'first_name' => [
			'The field first_name is required',
			'The field first_name must be alpha-numeric',
		],
		'email' => [
			'The email field is required',
			'The email address is not valid',
		],
	]
]

--}}

{{-- if we get a MessageProvider instance, convert it into a ViewErrorBag --}}
@if($errors instanceof \Illuminate\Contracts\Support\MessageProvider)
	<?php
	$errors = with(new \Illuminate\Support\ViewErrorBag)->put('default', $errors)
	?>
@endif

@if (count($errors->getBags()) > 0)
	<div class="callout alert">
			{{-- A bag is a group of related messages --}}
			@foreach ($errors->getBags() as $bag_name => $message_bag)
				@if($bag_name != 'default')
					{{$bag_name}}
				@endif
				{{-- The 'test_* class is used to target this element from the unit tests --}}
				<ul class="test_{{snake_case($bag_name)}}">
					@foreach($message_bag->all() as $message)
						<li>{{ $message }}</li>
					@endforeach
				</ul>
		@endforeach
	</div>
@endif