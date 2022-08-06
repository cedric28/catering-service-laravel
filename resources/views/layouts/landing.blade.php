<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Catering Service') }}</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('landing-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('landing-assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
	<link href="{{ asset('landing-assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('landing-assets/css/colors/orange.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ asset('landing-assets/js/modernizer.js') }}"></script>
	<!-- /global stylesheets -->
	@stack('styles')
	

</head>
<body class="bg-gradient-primary">
    <!-- Contents -->
    @yield('content')
    
	<!-- Theme JS files -->
	<script src="{{ asset('landing-assets/js/all.js') }}"></script>
	<script src="{{ asset('landing-assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('landing-assets/js/custom.js') }}"></script>

	@yield('js')
	@stack('scripts')
	
</body>
</html>
     