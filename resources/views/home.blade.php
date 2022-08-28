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
									Pending Events</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $plannerPendings }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-tasks fa-2x text-gray-300"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-primary shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									Total Users</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
							</div>
							<div class="col-auto">
								<i class="fas fa-users fa-2x text-gray-300"></i>
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
					<div class="card-header">
						Event Labels
					</div>
					<div class="card-body">
						<div id="external-events">
							<div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative;">Done</div>
							<!-- <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative;">G</div> -->
							<div class="external-event bg-info ui-draggable ui-draggable-handle" style="position: relative;">On Going Event</div>			
						</div>
					</div>
				</div>
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
								<div class="h5 mb-0 font-weight-bold text-gray-800">Ember Event</div>
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
		<script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
		<script>
			let planners = {!! json_encode($planners) !!};
			const filteredPlanners = planners.reduce((prevPlan, currPlan) => {
				prevPlan.push({
					id: currPlan.id,
					title: currPlan.event_name + ' ' + currPlan.event_time,
					start: currPlan.event_date,
					end: currPlan.event_date,
					className: currPlan.status === 'on-going' ?  'bg-gradient-info' : 'bg-gradient-success'

				});

				return prevPlan;
			},[]);
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
			initialDate: new Date(),
			events: [
				...filteredPlanners
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
			eventClick: function(info) {
				console.log(info);
				alert('Event: ' + info.event.id);
				// alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
				// alert('View: ' + info.view.type);

				// // change the border color just for fun
				// info.el.style.borderColor = 'red';
			}
			});

			calendar.render();
		</script>
		
        @endpush('scripts')
@endsection