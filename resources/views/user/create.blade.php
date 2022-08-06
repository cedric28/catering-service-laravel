@extends('layouts.app')

@section('content')

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Users</span> - New Record</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="{{ route('users.index')}}" class="breadcrumb-item"> Users</a>
							<a href="{{ route('users.create')}}" class="breadcrumb-item active"> Add New Record</a>
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
									<h5 class="card-title">User Form</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								@include('partials.message')
								@include('partials.errors')
								<form action="{{ route('users.store')}}" method="POST">
									@csrf
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Fullname:</label>
										<div class="col-lg-9">
											<input type="text" name="name" value="{{ old("name")}}" class="@error('name') is-invalid @enderror form-control form-control-user" placeholder="Fullname">
										</div>
									</div>

									

									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Email:</label>
										<div class="col-lg-9">
											<input type="email" name="email" value="{{ old("email")}}" class="@error('email') is-invalid @enderror form-control form-control-user" placeholder="Email">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Password:</label>
										<div class="col-lg-9">
											<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password"  required autocomplete="new-password">
										</div>
									</div>


									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Confirm Password:</label>
										<div class="col-lg-9">
											<input type="password" class="form-control" name="confirm-password"  placeholder="Confirm Password"  required autocomplete="new-password">
										</div>
									</div>
									

									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Role:</label>
										<div class="col-lg-9">
											<select id="role-id" name="role_id" class="form-control">
												<option value="">Select User Role</option>
												@foreach ($roles as $role)
													<option value="{{ $role->id }}"{{ ($role->name === old('role_id')) ? ' selected' : '' }}>{{ strtoupper($role->name) }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Job Type:</label>
										<div class="col-lg-9">
											<select id="job-id" name="job_type_id" class="form-control">
												<option value="">Select Job Type</option>
												@foreach ($job_types as $job)
													<option value="{{ $job->id }}"{{ ($job->name === old('job_type_id')) ? ' selected' : '' }}>{{ strtoupper($job->name) }}</option>
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
			</div>
			<!-- /content area -->
        @push('scripts')
        <!-- Javascript -->
		
        @endpush('scripts')
@endsection