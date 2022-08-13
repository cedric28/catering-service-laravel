@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Food Category</span> -  {{ ucwords($food_category->name) }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('food-category.index')}}" class="breadcrumb-item">Food Category</a>
					<a href="{{ route('food-category.show', $food_category->id )}}" class="breadcrumb-item active"> {{ ucwords($food_category->name) }} Details</a>
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
						<h5 class="card-title">Food Category Form</h5>
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
									<th>Food Category</th>
									<th>{{ $food_category->name }}</th>
								</tr>
								<tr>
									<th>Dish Category</th>
									<th>{{ $food_category->dish_category->name }}</th>
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