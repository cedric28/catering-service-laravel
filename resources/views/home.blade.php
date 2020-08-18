@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Dashboard</span></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->
			<!-- Content area -->
			<div class="content">
				<div class="row">
					<div class="col-xl-12">
						<!-- Search field -->
						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Dashboard Charts & Graphs</h6>
			
							</div>

							<div class="card-body py-0">
								<div class="row">
									<div class="col-lg-3">
		
										<!-- Members online -->
										<div class="card bg-teal-400">
											<div class="card-body">
												<div class="d-flex">
												<h3 class="font-weight-semibold mb-0">{{ $product }}</h3>
												</div>
												
												<div>
													Total Products
													
												</div>
											</div>
		
											<div class="container-fluid">
												<div id="members-online"></div>
											</div>
										</div>
										<!-- /members online -->
		
									</div>
		
									<div class="col-lg-3">
		
										<!-- Current server load -->
										<div class="card bg-pink-400">
											<div class="card-body">
												<div class="d-flex">
													<h3 class="font-weight-semibold mb-0">{{ $user }}</h3>
												</div>
												
												<div>
													Total Employees
													
												</div>
											</div>
		
											<div id="server-load"></div>
										</div>
										<!-- /current server load -->
		
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
        @push('scripts')
        <!-- Javascript -->
        <!-- Vendors -->
      
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        @endpush('scripts')
@endsection
