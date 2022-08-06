@extends('layouts.app')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Users</span> -  {{ ucwords($user->name) }} Details</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                            <a href="{{ route('users.index')}}" class="breadcrumb-item"> Users</a>
                            <a href="{{ route('users.show', $user->id )}}" class="breadcrumb-item active"> {{ ucwords($user->name) }} Details</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->

				<div class="card shadow mb-4">
					<div class="card-header ">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">User Form</h5>
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
												<th>Fullname</th>
												<th>{{ $user->name }}</th>
											</tr>
											<tr>
												<th>Email</th>
												<th>{{ $user->email }}</th>
											</tr>
											<tr>
												<th>Role</th>
												<th>{{ $user->role->name }}</th>
											</tr>
											<tr>
												<th>Job Type</th>
												<th>{{ $user->job_type->name }}</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
	<!-- /page content -->
        @push('scripts')
       
        @endpush('scripts')
@endsection