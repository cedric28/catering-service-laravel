@extends('layouts.app')

@section('content')
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
		let planner_id = {!! json_encode($planner->id) !!};
		let event_name = {!! json_encode($planner->event_name) !!};
		let planner_show = 1;
	</script>
@endpush
	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Event</span> -  {{ ucwords($planner->event_name) }} Details</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('planners.index')}}" class="breadcrumb-item">Events</a>
					<a href="{{ route('planners.show', $planner->id )}}" class="breadcrumb-item active"> {{ ucwords($planner->event_name) }} Details</a>
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
						<div style="width: 100%">
							<h5 class="card-title float-left">Planner Form</h5>
							<a href="{{ route('generateContract', $planner->id)}}" class="btn btn-success float-right ml-2">Generate Contract <i class="fas fa-print ml-2"></i></a>	
							<a href="{{ route('generateInvoice', $planner->id)}}"  class="btn btn-info float-right">Generate Invoice <i class="fas fa-print ml-2"></i></a>	
						</div>
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
									<th>Event Name</th>
									<th>{{ $planner->event_name }}</th>
								</tr>
								<tr>
									<th>Venue</th>
									<th>{{ ucwords($planner->event_venue) }}</th>
								</tr>
								<tr>
									@php
										$eventDate = $planner->event_date.' | '.$planner->event_time;
									@endphp
									<th>Date & Time</th>
									<th>{{ $eventDate }}</th>
								</tr>
								<tr>
									<th>Package</th>
									<th>{{ $planner->package->name }} - {{ $planner->package->main_package->name }}</th>
								</tr>
								<tr>
									<th>No of Guests</th>
									<th>{{ $planner->no_of_guests }} persons</th>
								</tr>
								<tr>
									<th>Notes</th>
									<th>{{ $planner->note }}</th>
								</tr>
								<tr>
									<th>Status</th>
									<th>{{ strtoupper($planner->status) }}</th>
								</tr>
								<tr>
									<th>Payment Status</th>
									<th>{{ strtoupper($planner->payment_status->name) }}</th>
								</tr>
								<tr>
									<th>Customer Fullname</th>
									<th>{{ ucwords($planner->customer->customer_firstname) }} {{ ucwords($planner->customer->customer_lastname) }}</th>
								</tr>
								<tr>
									<th>Contact No.</th>
									<th>+63{{ $planner->customer->contact_number }}</th>
								</tr>
							</thead>
						</table>
					</div>
					<div class="card shadow card-primary card-outline card-outline-tabs border-top-primary">
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
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-payment-tab" data-toggle="pill" href="#custom-tabs-payment" role="tab" aria-controls="custom-tabs-payment" aria-selected="false">Payments</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-four-tabContent">
								<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
									@include('planner.tables_show.task')
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
									@include('planner.tables_show.equipments')
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
									@include('planner.tables_show.food')
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
									@include('planner.tables_show.other')
								</div>
								<div class="tab-pane fade" id="custom-tabs-task-distribution" role="tabpanel" aria-labelledby="custom-tabs-task-distribution-tab">
									@include('planner.tables_show.staffing')
								</div>
								<div class="tab-pane fade" id="custom-tabs-time-table" role="tabpanel" aria-labelledby="custom-tabs-time-table-tab">
									@include('planner.tables_show.timetable')
								</div>
								<div class="tab-pane fade" id="custom-tabs-beo" role="tabpanel" aria-labelledby="custom-tabs-beo-tab">
									@include('planner.tables_show.beo')
								</div>
								<div class="tab-pane fade" id="custom-tabs-payment" role="tabpanel" aria-labelledby="custom-tabs-payment-tab">
									@include('planner.tables_show.payment')
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
        
        @endpush('scripts')
@endsection