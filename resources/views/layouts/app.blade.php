<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'FarmApp') }}</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
	<link
	href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
	rel="stylesheet">

    <!-- Custom styles for this template-->
	<link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  	<link rel="stylesheet" href="{{ asset('assets/js/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  	<link rel="stylesheet" href="{{ asset('assets/js/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
	<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<style>
		table td.textRight {
			text-align : right;
		}
		table td.textCenter {
			text-align : center;
		}
	</style>
	@stack('styles')
	

</head>
<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		@includeWhen(Auth::user(), 'partials.sidebar')
	    <!-- Content Wrapper -->
		   <div id="content-wrapper" class="d-flex flex-column">
			<!-- Main Content -->
			<div id="content">
				<!-- Header -->
				@includeWhen(Auth::user(), 'partials.header')
				<!-- Begin Page Content -->
                <div class="container-fluid">
					<!-- Contents -->
					@yield('content')
				</div>
			</div>
			<!-- Footer -->
			@includeWhen(Auth::user(), 'partials.footer')
				
		   </div>
	@auth
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	@endauth
	</div>
    <!-- Utils -->
	<a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
	<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
	<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

	<!-- Theme JS files -->
	@yield('js')
	@stack('scripts')
</body>
</html>
     