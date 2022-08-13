@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Food </span> - {{ $food->name }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('foods.index')}}" class="breadcrumb-item">Foods</a>
					<a href="{{ route('foods.edit', $food->id)}}" class="breadcrumb-item active"> Edit Details</a>
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
						<h5 class="card-title">Food Form</h5>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
		
			<div class="row">
				<div class="col-md-10 offset-md-1">
					
					<form action="{{ route('foods.update', $food->id )}}" method="POST">
						@csrf
						@method('PATCH')
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Food Name:</label>
							<div class="col-lg-9">
								<input type="text" name="name" value="{{ old("name" , $food->name)}}" class="@error('name') is-invalid @enderror form-control" placeholder="Food name">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Food Category:</label>
							<div class="col-lg-9">
								<select id="category_id" name="category_id" class="@error('category_id') is-invalid @enderror form-control select2">
									<option value="">Select Dish Category</option>
									@foreach ($food_categories as $category)
										<option value="{{ $category->id }}"{{ ($category->id == old('category_id', $food->category_id)) ? ' selected' : '' }}>{{ ucwords($category->name) }}</option>
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
        @push('scripts')
        @endpush('scripts')
@endsection