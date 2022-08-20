@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Package</span> - New Record</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('packages.index')}}" class="breadcrumb-item">Packages</a>
					<a href="{{ route('packages.create')}}" class="breadcrumb-item active"> Add New Record</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
			
	<div class="card">
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
					<form action="{{ route('packages.store')}}" method="POST">
						@csrf
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Name:</label>
							<div class="col-lg-9">
								<input type="text" name="name" value="{{ old("name") }}" class="@error('name') is-invalid @enderror form-control" placeholder="Package name (e.g Bronze Package)">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Pax:</label>
							<div class="col-lg-9">
								<input type="text" name="package_pax" value="{{ old("package_pax") }}" class="@error('package_pax') is-invalid @enderror form-control" placeholder="Package pax">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Price:</label>
							<div class="col-lg-9">	
								<input type="text" name="package_price" value="{{ old('package_price') }}" class="@error('package_price') is-invalid @enderror form-control" placeholder="Package Price" >
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package Category:</label>
							<div class="col-lg-9">
								<select id="main_package_id" name="main_package_id" class="@error('main_package_id') is-invalid @enderror form-control select2">
									<option value="">Select Package Category</option>
									@foreach ($package_categories as $category)
										<option value="{{ $category->id }}"{{ ($category->id === old('main_package_id')) ? ' selected' : '' }}>{{ ucwords($category->name) }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
	@push('scripts')
	
	@endpush('scripts')
@endsection