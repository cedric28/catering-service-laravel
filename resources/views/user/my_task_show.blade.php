@extends('layouts.app')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						@if(Auth::user()->job_type_id == 2)
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Task Event</span> -  {{ ucwords($taskNotif->planner_task_staff->planner_task->planner->event_name) }} Details</h4>
						@else
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Task Event</span> -  {{ ucwords($taskNotif->planner_staffing->planner->event_name) }} Details</h4>
						@endif
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                            <a href="{{ route('my-tasks.index')}}" class="breadcrumb-item"> My Tasks</a>
                            @if(Auth::user()->job_type_id == 2)
                            <a href="{{ route('my-tasks.show', $taskNotif->id )}}" class="breadcrumb-item active"> Task Event {{ ucwords($taskNotif->planner_task_staff->planner_task->planner->event_name) }} Details</a>
                            @else
                            <a href="{{ route('my-tasks.show', $taskNotif->id )}}" class="breadcrumb-item active"> Task Event {{ ucwords($taskNotif->planner_staffing->planner->event_name) }} Details</a>
                            @endif
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->

				<div class="card shadow mb-4">
					<div class="card-header ">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">Task Details</h5>
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
										@if(Auth::user()->job_type_id == 2)
											<tr>
												<th>Event Name</th>
												<th>{{ ucwords($taskNotif->planner_task_staff->planner_task->planner->event_name) }}</th>
											</tr>
											<tr>
												<th>Event Place</th>
												<th>{{ ucwords($taskNotif->planner_task_staff->planner_task->planner->event_venue) }}</th>
											</tr>
											<tr>
												<th>Event Date and Time</th>
												<th>{{ $taskNotif->planner_task_staff->planner_task->planner->event_date }} | {{ $taskNotif->planner_task_staff->planner_task->planner->event_time }}</th>
											</tr>
											<tr>
												<th>Event Status</th>
												<th>{{ strtoupper($taskNotif->planner_task_staff->planner_task->planner->status) }}</th>
											</tr>
											<tr>
												<th>Task</th>
												<th>{{ $taskNotif->planner_task_staff->planner_task->package_task->name }}</th>
											</tr>
											<tr>
												<th>Task Status</th>
												<th>{{ strtoupper($taskNotif->planner_task_staff->planner_task->status) }}</th>
											</tr>
											@else
											<tr>
												<th>Event Name</th>
												<th>{{ ucwords($taskNotif->planner_staffing->planner->event_name) }}</th>
											</tr>
											<tr>
												<th>Event Place</th>
												<th>{{ ucwords($taskNotif->planner_staffing->planner->event_venue) }}</th>
											</tr>
											<tr>
												<th>Event Date and Time</th>
												<th>{{ $taskNotif->planner_staffing->planner->event_date }} | {{ $taskNotif->planner_staffing->planner->event_time }}</th>
											</tr>
											<tr>
												<th>Event Status</th>
												<th>{{ strtoupper($taskNotif->planner_staffing->planner->status) }}</th>
											</tr>
											<tr>
												<th>Task</th>
												<th>{{ strtoupper(Auth::user()->job_type->name) }}</th>
											</tr>
											@endif
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
	<!-- /page content -->
@endsection