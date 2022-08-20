@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Event</span> - New Record</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('planners.index')}}" class="breadcrumb-item"> Events</a>
					<a href="{{ route('planners.create')}}" class="breadcrumb-item active"> Add New Record</a>
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
						<h5 class="card-title">Event Form</h5>
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-10 offset-md-1">
					<form action="{{ route('planners.store')}}" method="POST">
						@csrf
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Event Name:</label>
							<div class="col-lg-9">
								<input type="text" name="event_name" value="{{ old('event_name') }}" class="@error('event_name') is-invalid @enderror form-control" placeholder="e.g Yash & Ivan Wedding">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Event Venue:</label>
							<div class="col-lg-9">
								<input type="text" name="event_venue" value="{{ old('event_venue') }}" class="@error('event_venue') is-invalid @enderror form-control" placeholder="e.g Manila Hotel">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Event Date & Time:</label>
							<div class="col-lg-9">
								<div class="input-group date" id="reservationdate" data-target-input="nearest">
									<input type="text" name="event_date" placeholder="2022-08-20 8:27 PM" onkeydown="return false;" class="@error('event_date') is-invalid @enderror form-control datetimepicker-input" data-target="#reservationdate"/>
									<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Package:</label>
							<div class="col-lg-9">
								<select id="package_id" name="package_id" class="@error('package_id') is-invalid @enderror form-control select2">
									<option value="">Select Package</option>
									@foreach ($packages as $package)
										<option value="{{ $package->id }}"{{ ($package->id === old('package_id')) ? ' selected' : '' }}>{{ ucwords($package->name) }} - {{ $package->main_package->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">No of Guests:</label>
							<div class="col-lg-9">
								<input type="number" name="no_of_guests" value="{{ old('no_of_guests') }}" class="@error('no_of_guests') is-invalid @enderror form-control" placeholder="e.g 100">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-form-label col-lg-3">Notes:</label>
							<div class="col-lg-9">
								<textarea rows="3" cols="3" name="note" class="@error('note') is-invalid @enderror form-control" placeholder="e.g special request"></textarea>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Payment Status:</label>
							<div class="col-lg-9">
								<select id="payment_status_id" name="payment_status_id" class="@error('payment_status_id') is-invalid @enderror form-control select2">
									<option value="">Select Payment Status</option>
									@foreach ($paymentStatus as $status)
										<option value="{{ $status->id }}"{{ ($status->id === old('payment_status_id')) ? ' selected' : '' }}>{{ ucwords($status->name) }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Customer Fullname:</label>
							<div class="col-lg-9">
								<input type="text" name="customer_fullname" value="{{ old('customer_fullname') }}" class="@error('customer_fullname') is-invalid @enderror form-control" placeholder="e.g Yash Lozano">
							</div>
						</div>	

						<div class="form-group row">
							<label class="col-lg-3 col-form-label">Customer Phone:</label>
							<div class="col-lg-9">	
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text">+63</span>
									</div>
									<input type="text" name="contact_number" value="{{ old('contact_number') }}" class="@error('contact_number') is-invalid @enderror form-control" placeholder="e.g 9176270449" >
								</div>
							</div>
						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Next <i class="icon-paperplane ml-2"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
	@push('scripts')
	
	<script>	

	$(function () {
	var bindDatePicker = function() {
			$("#reservationdate").datetimepicker({
				showClear: true,
				showClose: true,
				allowInputToggle: true,
				useCurrent: false,
				ignoreReadonly: true,
				minDate: new Date(),
				format:'YYYY-MM-DD | hh:mm A',
				icons: {
					time: "fas fa-clock",
					date: "fas fa-calendar",
					up: "fas fa-chevron-up",
					down: "fas fa-chevron-down"
				}
			}).find('input:first').on("blur",function () {
				// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
				// update the format if it's yyyy-mm-dd
				var date = parseDate($(this).val());

				if (! isValidDate(date)) {
					//create date based on momentjs (we have that)
					date = moment().format('YYYY-MM-DD | hh:mm A');
				}

				$(this).val(date);
			});
		}
	
	var isValidDate = function(value, format) {
			format = format || false;
			// lets parse the date to the best of our knowledge
			if (format) {
				value = parseDate(value);
			}

			var timestamp = Date.parse(value);

			return isNaN(timestamp) == false;
	}
	
	var parseDate = function(value) {
			var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
			if (m)
				value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

			return value;
	}
	
	bindDatePicker();
 });
	</script>
	@endpush('scripts')
@endsection