@extends('layouts.app')

@section('content')
			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">My Tasks</span></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                            <a href="{{ route('my-tasks.index')}}" class="breadcrumb-item"> My Tasks</a>
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
									<h5 class="card-title">MY TASKS LIST</h5>
								</div>
							</div>
						</div>
					</div>
					
					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="table-responsive">
									@if(Auth::user()->job_type_id == 2 || Auth::user()->job_type_id == 1)
										<table class="table table-bordered" id="userTaskStaff"  width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>EVENT NAME</th>
													<th>EVENT PLACE</th>
													<th>TASK DATE & TIME</th>
													<th>TASK NAME</th>
													<th>TASK STATUS</th>
													<th>ACTION</th>
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
													<th>ACTION</th>
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
			let user_id = {!! json_encode(Auth::user()->id) !!};
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
						"my_task" : 1
					}
				},
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'collection',
						"text": 'Export',
						"buttons": [
							{
								"extend": 'csv',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								}
							},
							{
								"extend": 'pdf',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								}
							},
							{
								"extend": 'print',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
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
					{"data":"action","searchable":false,"orderable":false}
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
						"my_task" : 1
					}
				},
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'collection',
						"text": 'Export',
						"buttons": [
							{
								"extend": 'csv',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								}
							},
							{
								"extend": 'pdf',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
								}
							},
							{
								"extend": 'print',
								'title' :`MY-TASK-LISTS`,
								"exportOptions": {
									"columns": [0,1,2,3,4]
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
					{"data":"action","searchable":false,"orderable":false}
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