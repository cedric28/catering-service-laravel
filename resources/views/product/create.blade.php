@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Product</span> - New Record</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="{{ route('product.index')}}" class="breadcrumb-item"> Products</a>
							<a href="{{ route('product.create')}}" class="breadcrumb-item active"> Add New Product</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
			
				<div class="card">
					<div class="card-header">
						@include('partials.message')
					    @include('partials.errors')
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">Product Form</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<form action="{{ route('product.store')}}" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Product Title:</label>
                                        <div class="col-lg-9">	
                                            <input type="text" name="title" value="{{ old('title') }}" class="@error('title') is-invalid @enderror form-control" placeholder="Title" >
                                        </div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-3">Content</label>
										<div class="col-lg-9">
											<textarea rows="3" cols="3" name="content" class="@error('content') is-invalid @enderror form-control" placeholder="Content"></textarea>
										</div>
									</div>

									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Photo:</label>
                                        <div class="col-lg-9">	
                                            <input type="file" name="image" class="@error('image') is-invalid @enderror form-control" placeholder="Image" >
                                        </div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Category:</label>
										<div class="col-lg-9">
											<select id="role-id" name="category_id" class="form-control">
												<option value="">Select category</option>
												@foreach ($categories as $category)
													<option value="{{ $category->id }}"{{ ($category->id === old('category_id')) ? ' selected' : '' }}>{{ strtoupper($category->title) }}</option>
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
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
        @push('scripts')
        <!-- Javascript -->
		<!-- Vendors -->
		<script>
			CKEDITOR.replace( 'content', {
				filebrowserBrowseUrl: '/js/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl: '/js/ckfinder/ckfinder.html?Type=Images',
				filebrowserUploadUrl: '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl: '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserWindowWidth : '1000',
				filebrowserWindowHeight : '700'
			} );
		</script>
      
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        @endpush('scripts')
@endsection