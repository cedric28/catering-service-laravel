@extends('layouts.app')

@section('content')
	
		<!-- Page Heading -->
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
		</div>
		<!-- Content Row -->
		<div class="row">
			@if(Auth::user()->job_type_id == 1 || Auth::user()->job_type_id == 2)
			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-danger shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
									Earnings (Month of {{ Carbon\Carbon::now()->format('F') }})</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlySales }}</div>
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
				<div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-success text-uppercase mb-1">COMPLETED EVENTS
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $plannerCompleted }}</div>
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
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-info text-uppercase mb-1">
									On-Going Events</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $plannerOnGoing }}</div>
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
			@endif
		</div>

		<!-- Content Row -->

		<div class="row">

			<!-- Area Chart -->
			<div class="col-xl-8 col-lg-7">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary mb-3">Calendar Events</h6>
						<div class="row">
							<div class="col-md-12">
								<div class="callout callout-info">
									<h5><i class="fas fa-info"></i> Note:</h5>
									Click an event in the calendar to see its details.
								</div>
							</div>
						</div>
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
							<div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative;">Completed</div>
							<!-- <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative;">G</div> -->
							<div class="external-event bg-info ui-draggable ui-draggable-handle" style="position: relative;">On Going Event</div>			
						</div>
					</div>
				</div>
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div
						class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Event Details</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="row no-gutters align-items-center mb-3">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
									<span id="event_date"></span>
								</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800"><span id="event_name">No Selected</span></div>
							</div>
							<div class="col-auto">
								<i class="fas fa-calendar fa-2x text-gray-300"></i>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<p class="text-muted"><strong><i class="fas fa-gift mr-1"></i> Package: </strong> <span id="event_package"></span></p>
								<p class="text-muted"><strong><i class="fas fa-map-marker-alt mr-1"></i> Event Place: </strong> <span id="event_place"></span></p>
								<p class="text-muted"><strong><i class="fas fa-clock mr-1"></i> Event Time: </strong> <span id="event_time"></span></p>
								<p class="text-muted"><strong><i class="fas fa-users mr-1"></i> No of Guests: </strong> <span id="no_of_guests">0 </span>persons</p>
								<p class="text-muted"><strong><i class="far fa-file-alt mr-1"></i> Notes: </strong> <span id="event_note"></span></p>

								<p class="text-muted"><strong><i class="far fa-user mr-1"></i> Client Name: </strong> <span id="customer"></span></p>
								<p class="text-muted"><strong><i class="fas fa-phone mr-1"></i> Contact No: </strong> +63<span id="contact_no"></span></p>

								<p class="text-muted"><strong><i class="fas fa-credit-card mr-1"></i> Payment Method: </strong> <span id="payment_method"></span></p>
								<p class="text-muted"><strong><i class="fas fa-money-bill-wave-alt mr-1"></i> Payment Status: </strong> <span id="payment_status"></span></p>
								<hr>
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
			$("#event_date").html("-");
			$("#event_package").html("-");
			$("#event_place").html("-");
			$("#event_time").html("-");
			$("#event_note").html("-");
			$("#customer").html("-");
			$("#contact_no").html("-");
			$("#payment_method").html("-");
			$("#payment_status").html("-");
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
				let planner_id =  info.event.id;
				$.ajax({
					url: "planners-show/"+planner_id,
					success:function(data)
					{
						console.log(data.data);
						const { event_name, event_date, event_venue, event_time, no_of_guests, note, customer_fullname, contact_number } = data.data;
						const payments = data.payments;
						const payment_method = payments.length > 0 ? payments[0].payment_type : 'No Payment Made';
						$("#event_date").html(data.formattedDate);
						$("#event_name").html(event_name)
						$("#event_package").html(data.package_name);
						$("#event_place").html(event_venue);
						$("#event_time").html(event_time);
						$("#no_of_guests").html(no_of_guests);
						$("#event_note").html(note);
						$("#customer").html(customer_fullname);
						$("#contact_no").html(contact_number);
						$("#payment_method").html(payment_method);
						$("#payment_status").html(data.payment_status);
					},
					error: function(response)
					{
						$("#event_date").html("");
						$("#event_name").html("")
						$("#event_package").html("");
						$("#event_place").html("");
						$("#event_time").html("");
						$("#no_of_guests").html("");
						$("#event_note").html("");
						$("#customer").html("");
						$("#contact_no").html("");
						$("#payment_method").html("");
						$("#payment_status").html("");
					}
				})
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