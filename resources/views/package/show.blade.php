@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Package</span> -  {{ ucwords($package->name) }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('packages.index')}}" class="breadcrumb-item">Packages</a>
					<a href="{{ route('packages.show', $package->id )}}" class="breadcrumb-item active"> {{ ucwords($package->name) }} Details</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
		
	<div class="card shadow">
		<div class="card-header ">
			<div class="row">
				<div class="col-md-10 offset-md-1">
					<div class="header-elements-inline">
						<h5 class="card-title">Package Form</h5>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-md-10 offset-md-1">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Package Name</th>
									<th>{{ $package->name }}</th>
								</tr>
								<tr>
									<th>Package Pax</th>
									<th>{{ Str::number_comma($package->package_pax) }}</th>
								</tr>
								<tr>
									<th>Package Price</th>
									<th>{{ Str::currency($package->package_price) }}</th>
								</tr>
								<tr>
									<th>Package Category</th>
									<th>{{ $package->main_package->name }}</th>
								</tr>
							</thead>
						</table>
					</div>
					<div class="card shadow card-primary card-outline card-outline-tabs border-top-primary mt-3">
						<div class="card-header p-0 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Tasks</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Equipments</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Food Menu</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Other</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-four-tabContent">
								<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
									@if($isShow == 0)
									<button type="button" id="add-task" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Task</button>
									@endif
									<div class="table-responsive">
										<table class="table table-bordered" id="package-tasks-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>TASK NAME</th>
													<th>DATE ADDED</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
									@if($isShow == 0)
									<button type="button" id="add-equipment" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Equipment</button>
									@endif
									<div class="table-responsive">
										<table class="table table-bordered" id="package-equipments-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>EQUIPMENT NAME</th>
													<th>QUANTITY</th>
													<th>DATE ADDED</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
									@if($isShow == 0)
									<button type="button" id="add-food" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Food</button>
									@endif
									<div class="table-responsive">
										<table class="table table-bordered" id="package-foods-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>FOOD CATEGORY</th>
													<th>DATE ADDED</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
									@if($isShow == 0)
									<button type="button" id="add-other" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Additional Service</button>
									@endif
									<div class="table-responsive">
										<table class="table table-bordered" id="package-others-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>NAME</th>
													<th>SERVICE FEE</th>
													<th>DATE ADDED</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- /page content -->
	@push('scripts')
		<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('assets/js/jszip/jszip.min.js') }}"></script>
		<script src="{{ asset('assets/js/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('assets/js/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-buttons/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('assets/js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
		<script>
			let packageId = {!! json_encode($package->id) !!};
    		let packageName = {!! json_encode($package->name) !!};
			let isShow = {!! json_encode($isShow) !!};
			let logo = window.location.origin + '/assets/img/logo-pink.png';
			let user_login = {!! json_encode( ucwords(Auth::user()->name)) !!};
			let dateToday = new Date();
		</script>
	@endpush('scripts')
	@include('package.modals.delete_modal')
	@include('package.modals.task_modal')
	@include('package.modals.food_modal')
	@include('package.modals.equipment_modal')
	@include('package.modals.other_modal')
@endsection