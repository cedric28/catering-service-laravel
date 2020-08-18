<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'FarmApp') }}</title>

	<!-- Global stylesheets -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	@stack('styles')
	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->
	<!-- /theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>

	<script src="{{ asset('global_assets/js/demo_pages/picker_date.js') }}"></script>
	<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
</head>
<body>
    <main class="main">
      <!-- Header -->
      @includeWhen(Auth::user(), 'partials.header')
	    <!-- Page content -->
	    <div class="page-content">
		
			<!-- Sidebar -->
			@includeWhen(Auth::user(), 'partials.sidebar')
				<!-- Contents -->
				@yield('content')
				
			<!-- Footer -->
			@includeWhen(Auth::user(), 'partials.footer')
				
       
    </main>
    <!-- Utils -->
    @auth
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
    @endauth
    
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
	@auth
		<script>
			window.user = @json(auth()->user())
		</script>
	@endauth
	<script src="/js/app.js"></script>
	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

	<script src="{{ asset('global_assets/js/demo_pages/dashboard.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/sparklines.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/lines.js') }}"></script>	
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/areas.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/donuts.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/bars.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/progress.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/pies.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/bullets.js') }}"></script>
	@yield('js')
	@stack('scripts')
	
</body>
</html>
     