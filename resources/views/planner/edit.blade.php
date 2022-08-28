@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Event</span> - {{ $planner->event_name }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('planners.index')}}" class="breadcrumb-item"> Events</a>
					<a href="{{ route('planners.edit', $planner->id)}}" class="breadcrumb-item active"> Edit Details</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
	@include('partials.message')
	@include('partials.errors')
	<div class="row">
		<div class="col-xl-4 col-md-4 mb-4">
			<div class="card shadow">
				<div class="card-header">
				
					<div class="row">
						<div class="col-md-12">
							<div class="header-elements-inline">
								<h5 class="card-title">Event Form</h5>
							</div>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<form action="{{ route('planners.update', $planner->id )}}" method="POST">
								@csrf
								@method('PATCH')
								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Event Name:</label>
									<div class="col-lg-9">
										<input type="text" name="event_name" value="{{ old('event_name', $planner->event_name) }}" class="@error('event_name') is-invalid @enderror form-control" placeholder="e.g Yash & Ivan Wedding">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Event Venue:</label>
									<div class="col-lg-9">
										<input type="text" name="event_venue" value="{{ old('event_venue', $planner->event_venue) }}" class="@error('event_venue') is-invalid @enderror form-control" placeholder="e.g Manila Hotel">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Event Date & Time:</label>
									<div class="col-lg-9">
										@php
											$eventDate = $planner->event_date.' | '.$planner->event_time;
										@endphp
										<div class="input-group date" id="reservationdate" data-target-input="nearest">
											<input type="text" name="event_date" value="{{ old('event_date', $eventDate) }}" placeholder="e.g 2022-08-20 8:27 PM" onkeydown="return false;" class="@error('event_date') is-invalid @enderror form-control datetimepicker-input" data-target="#reservationdate"/>
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
												<option data-guest="{{ $package->package_pax }}" value="{{ $package->id }}" {{ ($package->id == old('package_id',$planner->package_id)) ? ' selected' : '' }}>{{ ucwords($package->name) }} - {{ $package->main_package->name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">No of Guests:</label>
									<div class="col-lg-9">
										<input id="no_of_guests" type="number" disabled name="no_of_guests" value="{{ old('no_of_guests', $planner->no_of_guests) }}" class="@error('no_of_guests') is-invalid @enderror form-control" placeholder="e.g 100">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-3">Notes:</label>
									<div class="col-lg-9">
										<textarea rows="3" cols="3" name="note" class="@error('note') is-invalid @enderror form-control" placeholder="e.g special request">{{ $planner->note }}</textarea>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Payment Status:</label>
									<div class="col-lg-9">
										<select id="payment_status_id" name="payment_status_id" class="@error('payment_status_id') is-invalid @enderror form-control select2">
											<option value="">Select Payment Status</option>
											@foreach ($paymentStatus as $status)
												<option value="{{ $status->id }}"{{ ($status->id == old('payment_status_id', $planner->payment_status_id)) ? ' selected' : '' }}>{{ ucwords($status->name) }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Customer Fullname:</label>
									<div class="col-lg-9">
										<input type="text" name="customer_fullname" value="{{ old('customer_fullname', $planner->customer_fullname) }}" class="@error('customer_fullname') is-invalid @enderror form-control" placeholder="e.g Yash Lozano">
									</div>
								</div>	

								<div class="form-group row">
									<label class="col-lg-3 col-form-label">Customer Phone:</label>
									<div class="col-lg-9">	
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text">+63</span>
											</div>
											<input type="text" name="contact_number" value="{{ old('contact_number',  $planner->contact_number) }}" class="@error('contact_number') is-invalid @enderror form-control" placeholder="e.g 9176270449" >
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

		<div class="col-xl-8 col-md-8 mb-4">
			<div class="card shadow">
				<div class="card-header">
					<div class="row">
						<div class="col-md-12">
							<div class="header-elements-inline">
								<h5 class="card-title">Event Details</h5>
							</div>
						</div>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
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
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-task-distribution-tab" data-toggle="pill" href="#custom-tabs-task-distribution" role="tab" aria-controls="custom-tabs-task-distribution" aria-selected="false">Employee Staffing</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-time-table-tab" data-toggle="pill" href="#custom-tabs-time-table" role="tab" aria-controls="custom-tabs-time-table" aria-selected="false">Time Table</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-beo-tab" data-toggle="pill" href="#custom-tabs-beo" role="tab" aria-controls="custom-tabs-beo" aria-selected="false">BEO</a>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-four-tabContent">
										<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											@include('planner.tables.task')
										</div>
										<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
											@include('planner.tables.equipments')
										</div>
										<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
											@include('planner.tables.food')
										</div>
										<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
											@include('planner.tables.other')
										</div>
										<div class="tab-pane fade" id="custom-tabs-task-distribution" role="tabpanel" aria-labelledby="custom-tabs-task-distribution-tab">
											@include('planner.tables.staffing')
										</div>
										<div class="tab-pane fade" id="custom-tabs-time-table" role="tabpanel" aria-labelledby="custom-tabs-time-table-tab">
											@include('planner.tables.timetable')
										</div>
										<div class="tab-pane fade" id="custom-tabs-beo" role="tabpanel" aria-labelledby="custom-tabs-beo-tab">
											@include('planner.tables.beo')
										</div>
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
	
	<script>	
	
	let packagePaxValue = $("#package_id option:selected" ).data('guest');
	$('#no_of_guests').val(packagePaxValue);
	$('#package_id').on('change', function() {
		let packagePaxValues = $(this).find(":selected").data('guest');
		$('#no_of_guests').val(packagePaxValues);
	});


	let eventDate = {!! json_encode($planner->event_date) !!};
	let d = new Date();
	let month = ('0' + (d.getMonth() + 1)).slice(-2);
	let day = ('0' + d.getDate()).slice(-2);
	let year = d.getFullYear();
	let formattedEventDate = new Date((new Date(eventDate)).valueOf() + 1000*3600*24);
	let formattedMonth = ('0' + (formattedEventDate.getMonth() + 1)).slice(-2);
	let formattedDay = ('0' + formattedEventDate.getDate()).slice(-2);
	let formattedYear = formattedEventDate.getFullYear();
	$(document).ready(function() {
		var bindDatePicker = function() {
			$("#reservationdate").datetimepicker({
				showClear: true,
				showClose: true,
				allowInputToggle: true,
				useCurrent: false,
				ignoreReadonly: true,
				minDate: `${year}-${month}-${day}`,
				maxDate: `${year}-12-31`,
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

	 $(document).ready(function() {
		let bindTaskDatePicker = function() {
			$("#taskdate").datetimepicker({
					showClear: true,
					showClose: true,
					allowInputToggle: true,
					useCurrent: false,
					ignoreReadonly: true,
					minDate: `${year}-${month}-${day}`,
					maxDate: `${formattedYear}-${formattedMonth}-${formattedDay}`,
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
		bindTaskDatePicker();
		
 	});


	 $(document).ready(function() {
		let bindTimeTablePicker = function() {
			$("#timetable").datetimepicker({
					showClear: true,
					showClose: true,
					allowInputToggle: true,
					useCurrent: false,
					ignoreReadonly: true,
					format:'hh:mm A',
				});
		}
		bindTimeTablePicker();
		
 	});
	</script>
	@endpush('scripts')
@endsection