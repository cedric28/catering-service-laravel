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
	<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  	<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
	<!-- jQuery -->
	<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Select2 -->
	<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
	<!-- 
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	 <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
 -->


	<!-- Theme JS files -->
	@yield('js')
	@stack('scripts')
</body>
</html>
     