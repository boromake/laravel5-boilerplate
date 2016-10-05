{{--
- This is the master/layout template for ALL TEMPLATES
- NO page/view should extend/reference this master template directly
--}}
<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>

	{{-- stylesheets --}}
	<link rel="stylesheet" href="{{ elixir('css/compiled/global.css') }}">
	@stack('css') {{-- placeholder to allow for more css files to be added by child views --}}

	{{-- javascript --}}
	<script src="{{asset('/build/js/vendor/jquery.min.js')}}"></script>
	@stack('scripts') {{-- placeholder to allow for more css files to be added by child views --}}

	{{-- meta tags --}}
	<meta content="text/html; charset=UTF-8" http-equiv="content-type" />

	@hasSection ('meta-description')
	<meta name="description" content="@yield('meta-description')">
	@endif

	@stack('meta') {{-- placeholder to allow for more meta tags to be added by child views --}}

	@hasSection('style')
		<style type="text/css">
			@yield('style')
		</style>
	@endif
</head>



<body>
	@yield('body')

	@stack('before-closing-body')

	{{-- Google Analytics --}}
	@include('_partials.google_analytics')
</body>

</html>