@extends('layouts.app')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Users</span> -  {{ ucwords($user->name) }} Details</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                            <a href="{{ route('users.index')}}" class="breadcrumb-item"> Users</a>
                            <a href="{{ route('users.show', $user->id )}}" class="breadcrumb-item active"> {{ ucwords($user->name) }} Details</a>
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
									<h5 class="card-title">User Form</h5>
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
												<th>Fullname</th>
												<th>{{ $user->name }}</th>
											</tr>
											<tr>
												<th>Email</th>
												<th>{{ $user->email }}</th>
											</tr>
											<tr>
												<th>Role</th>
												<th>{{ $user->role->name }}</th>
											</tr>
											<tr>
												<th>Job Type</th>
												<th>{{ $user->job_type->name }}</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="table-responsive">
									@if($user->job_type_id == 2 || $user->job_type_id == 1)
										<table class="table table-bordered" id="userTaskStaff"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>EVENT NAME</th>
													<th>EVENT PLACE</th>
													<th>TASK DATE & TIME</th>
													<th>TASK NAME</th>
													<th>TASK STATUS</th>
													
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									@else
										<table class="table table-bordered" id="userStaffing"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>EVENT NAME</th>
													<th>EVENT PLACE</th>
													<th>EVENT DATE & TIME</th>
													<th>EVENT STATUS</th>
													<th>ATTENDANCE</th>
													
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
	<!-- /page content -->
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
			let logo = window.location.origin + '/assets/img/logo-pink.png';
			let user_login = {!! json_encode( ucwords(Auth::user()->name)) !!};
			let dateToday = new Date();
			let user_id = {!! json_encode($user->id) !!};
			var table = $('#userTaskStaff').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('activeUserTaskStaff') ?>",
					"dataType":"json",
					"type":"POST",
					"data":{
						"_token":"<?= csrf_token() ?>",
						"user_id": user_id,
						"my_task" : 0
					}
				},
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'collection',
						"text": 'Export',
						"buttons": [
							// {
							// 	"extend": 'csv',
							// 	'title' :`USER-TASK-LISTS`,
							// 	"exportOptions": {
							// 		"columns": [0,1,2,3,4]
							// 	}
							// },
							// {
							// 	"extend": 'pdf',
							// 	'title' :`USER-TASK-LISTS`,
							// 	"exportOptions": {
							// 		"columns": [0,1,2,3,4]
							// 	}
							// },
							{
								"extend": 'print',
								'title' : ``,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								},
								"customize": function ( win ) {
									$(win.document.body)
										.css( 'font-size', '10pt' )
										.prepend(
											`
											<div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
												<div class="title-header">
													<h2>USER-TASK-LISTS</h2>
													<h5>Date Issued: ${dateToday.toDateString()}</h5>
													<h5>Prepared By: ${user_login}</h5>
												</div>
												<div class="image-header">
													<img src="${logo}" style=""/>
												</div>
											</div>
											`
										);
				
									$(win.document.body).find( 'table' )
										.addClass( 'compact' )
										.css( 'font-size', 'inherit' );
								}
							}
						],
					}
				],
				"columns":[
					{"data":"event_name"},
					{"data":"event_place"},
					{"data":"task_date_time"},
					{"data":"task_name"},
					{"data":"task_status"},
				],
				"columnDefs": [
					{
						"targets": [0,1,2,3,4],   // target column
						"className": "textCenter",
					}
				]
			});


			var userStaffingTable = $('#userStaffing').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('activeUserStaffing') ?>",
					"dataType":"json",
					"type":"POST",
					"data":{
						"_token":"<?= csrf_token() ?>",
						"user_id": user_id,
						"my_task" : 0
					}
				},
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'collection',
						"text": 'Export',
						"buttons": [
							// {
							// 	"extend": 'csv',
							// 	'title' :`USER-TASK-LISTS`,
							// 	"exportOptions": {
							// 		"columns": [0,1,2,3,4]
							// 	}
							// },
							// {
							// 	"extend": 'pdf',
							// 	'title' :`USER-TASK-LISTS`,
							// 	"exportOptions": {
							// 		"columns": [0,1,2,3,4]
							// 	}
							// },
							{
								"extend": 'print',
								'title' : ``,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								},
								"customize": function ( win ) {
									$(win.document.body)
										.css( 'font-size', '10pt' )
										.prepend(
											`
											<div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
												<div class="title-header">
													<h2>USER-TASK-LISTS</h2>
													<h5>Date Issued: ${dateToday.toDateString()}</h5>
													<h5>Prepared By: ${user_login}</h5>
												</div>
												<div class="image-header">
													<img src="${logo}" style=""/>
												</div>
											</div>
											`
										);
				
									$(win.document.body).find( 'table' )
										.addClass( 'compact' )
										.css( 'font-size', 'inherit' );
								}
							}
						],
					}
				],
				"columns":[
					{"data":"event_name"},
					{"data":"event_place"},
					{"data":"event_date_time"},
					{"data":"event_status"},
					{"data":"attendance"},
				],
				"columnDefs": [
					{
						"targets": [0,1,2,3,4],   // target column
						"className": "textCenter",
					}
				]
			});
		</script>
        @endpush('scripts')
@endsection