@extends('layouts.app')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Customers</span> - {{ $customer->customer_lastname }}, {{ $customer->customer_firstname }} Details</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="{{ route('customers.index')}}" class="breadcrumb-item"> Customers</a>
							<a href="{{ route('customers.edit', $customer->id)}}" class="breadcrumb-item active"> Edit Details</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
				<div class="card shadow">
					<div class="card-header">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">Customer Form</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								@include('partials.message')
								@include('partials.errors')
								<form action="{{ route('customers.update', $customer->id )}}" method="POST">
                                    @csrf
                                    @method('PATCH')
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Customer First name:</label>
										<div class="col-lg-9">
											<input type="text" name="customer_firstname" value="{{ old('customer_firstname', $customer->customer_firstname) }}" class="@error('customer_firstname') is-invalid @enderror form-control" placeholder="e.g Yash">
										</div>
									</div>	
			
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Customer Last name:</label>
										<div class="col-lg-9">
											<input type="text" name="customer_lastname" value="{{ old('customer_lastname', $customer->customer_lastname) }}" class="@error('customer_lastname') is-invalid @enderror form-control" placeholder="e.g Lozano">
										</div>
									</div>	
			
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Customer Phone:</label>
										<div class="col-lg-9">	
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text">+63</span>
												</div>
												<input type="text" name="contact_number" value="{{ old('contact_number', $customer->contact_number) }}" class="@error('contact_number') is-invalid @enderror form-control" placeholder="e.g 9176270449" >
											</div>
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
			</div>
			<!-- /content area -->
	<!-- /page content -->
        @push('scripts')
        <!-- Javascript -->
		<!-- Vendors -->
		
        @endpush('scripts')
@endsection