@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Package </span> - {{ $package->name }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('packages.index')}}" class="breadcrumb-item">Packages</a>
					<a href="{{ route('packages.edit', $package->id)}}" class="breadcrumb-item active"> Edit Details</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
			
	<div class="card shadow">
		<div class="card-header">
			@include('partials.message')
			@include('partials.errors')
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
					<form action="{{ route('packages.update', $package->id )}}" method="POST">
						@csrf
						@method('PATCH')
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Name:</label>
							<div class="col-lg-9">
								<input type="text" name="name" value="{{ old("name" , $package->name)}}" class="@error('name') is-invalid @enderror form-control" placeholder="Package name (e.g Bronze Package)">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Pax:</label>
							<div class="col-lg-9">
								<input type="text" name="package_pax" value="{{ old('package_pax', $package->package_pax) }}" class="@error('package_pax') is-invalid @enderror form-control" placeholder="Package pax">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Price:</label>
							<div class="col-lg-9">	
								<input type="text" name="package_price" value="{{ old('package_price', $package->package_price) }}" class="@error('package_price') is-invalid @enderror form-control" placeholder="Package Price" >
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Category:</label>
							<div class="col-lg-9">
								<select id="main_package_id" name="main_package_id" class="@error('main_package_id') is-invalid @enderror form-control select2">
									<option value="">Select Package Category</option>
									@foreach ($package_categories as $category)
										<option value="{{ $category->id }}" {{ ($category->id == old('main_package_id', $package->main_package_id)) ? ' selected' : '' }}>{{ ucwords($category->name) }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
						</div>
					</form>
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
									<button type="button" id="add-task" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Task</button>
									<div class="table-responsive">
										<table class="table table-bordered" id="package-tasks-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>TASK NAME</th>
													<th>DATE ADDED</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
									<button type="button" id="add-equipment" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Equipment</button>
									<div class="table-responsive">
										<table class="table table-bordered" id="package-equipments-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>EQUIPMENT NAME</th>
													<th>QUANTITY</th>
													<th>DATE ADDED</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
									<button type="button" id="add-food" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Food</button>
									<div class="table-responsive">
										<table class="table table-bordered" id="package-foods-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>FOOD CATEGORY</th>
													<th>DATE ADDED</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
									<button type="button" id="add-other" class="btn btn-outline-success btn-sm float-left mb-2"><i class="mr-2"></i> Add Additional Service</button>
									<div class="table-responsive">
										<table class="table table-bordered" id="package-others-lists"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>NAME</th>
													<th>SERVICE PRICE</th>
													<th>DATE ADDED</th>
													<th>ACTION</th>
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
		</script>
	@endpush('scripts')
	@include('package.modals.delete_modal')
	@include('package.modals.task_modal')
	@include('package.modals.food_modal')
	@include('package.modals.equipment_modal')
	@include('package.modals.other_modal')
@endsection