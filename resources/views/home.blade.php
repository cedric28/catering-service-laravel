@extends('layouts.app')

@section('content')
	
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		</div>
		<!-- Content Row -->
		<div class="row">
			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									Earnings (Monthly)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-calendar fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
									Earnings (Annual)</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
									</div>
									<div class="col">
										<div class="progress progress-sm mr-2">
											<div class="progress-bar bg-info" role="progressbar"
												style="width: 50%" aria-valuenow="50" aria-valuemin="0"
												aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Pending Requests Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
									Pending Requests</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-comments fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Content Row -->

		<div class="row">

			<!-- Area Chart -->
			<div class="col-xl-8 col-lg-7">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div
						class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Calendar Events</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div id='calendar'></div>
					</div>
				</div>
			</div>

			<!-- Pie Chart -->
			<div class="col-xl-4 col-lg-5">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div
						class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Upcoming Events</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									December 20,2022
								</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">Angelyn Birthday</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-calendar fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        @push('scripts')
        <!-- Javascript -->
		<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
		<script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
		<script>
			var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
				contentHeight: 'auto',
				initialView: "dayGridMonth",
				headerToolbar: {
					start: 'title', // will normally be on the left. if RTL, will be on the right
					center: '',
					end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
				},
			selectable: true,
			editable: true,
			initialDate: '2020-12-01',
			events: [{
				title: 'Call with Dave',
				start: '2020-11-18',
				end: '2020-11-18',
				className: 'bg-gradient-danger'
				},

				{
				title: 'Lunch meeting',
				start: '2020-11-21',
				end: '2020-11-22',
				className: 'bg-gradient-warning'
				},

				{
				title: 'All day conference',
				start: '2020-11-29',
				end: '2020-11-29',
				className: 'bg-gradient-success'
				},

				{
				title: 'Meeting with Mary',
				start: '2020-12-01',
				end: '2020-12-01',
				className: 'bg-gradient-info'
				},

				{
				title: 'Winter Hackaton',
				start: '2020-12-03',
				end: '2020-12-03',
				className: 'bg-gradient-danger'
				},

				{
				title: 'Digital event',
				start: '2020-12-07',
				end: '2020-12-09',
				className: 'bg-gradient-warning'
				},

				{
				title: 'Marketing event',
				start: '2020-12-10',
				end: '2020-12-10',
				className: 'bg-gradient-primary'
				},

				{
				title: 'Dinner with Family',
				start: '2020-12-19',
				end: '2020-12-19',
				className: 'bg-gradient-danger'
				},

				{
				title: 'Black Friday',
				start: '2020-12-23',
				end: '2020-12-23',
				className: 'bg-gradient-info'
				},

				{
				title: 'Cyber Week',
				start: '2020-12-02',
				end: '2020-12-02',
				className: 'bg-gradient-warning'
				},

			],
			views: {
				month: {
				titleFormat: {
					month: "long",
					year: "numeric"
				}
				},
				agendaWeek: {
				titleFormat: {
					month: "long",
					year: "numeric",
					day: "numeric"
				}
				},
				agendaDay: {
				titleFormat: {
					month: "short",
					year: "numeric",
					day: "numeric"
				}
				}
			},
			});

			calendar.render();
		</script>
		
        @endpush('scripts')
@endsection