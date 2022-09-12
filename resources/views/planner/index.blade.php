@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Events</span></h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('planners.index')}}" class="breadcrumb-item">Events</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			@if(Auth::user()->job_type_id == 1)
			<a type="button" href="{{ route('planners.create')}}" class="btn btn-outline-success btn-sm float-left"><i class="icon-add mr-2"></i> Add Event</a>
			@endif
		</div>
		<div class="card-body">
			<div class="card shadow card-primary card-outline card-outline-tabs border-top-primary">
				<div class="card-header p-0 border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Done Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">On-Going Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Pending Events</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Inactive Events</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="custom-tabs-four-tabContent">
						<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<div class="table-responsive">
								<table class="table table-bordered" id="planners-done-lists"  width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>EVENT NAME</th>
											<th>EVENT PLACE</th>
											<th>EVENT DATE & TIME</th>
											<th>EVENT TYPE & PACKAGE</th>
											<th>NO OF GUESTS</th>
											<th>CUSTOMER NAME</th>
											<th>EVENT STATUS</th>
											<th>DATE ADDED</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
							<div class="table-responsive">
								<table class="table table-bordered" id="planners-ongoing-lists"  width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>EVENT NAME</th>
											<th>EVENT PLACE</th>
											<th>EVENT DATE & TIME</th>
											<th>EVENT TYPE & PACKAGE</th>
											<th>NO OF GUESTS</th>
											<th>CUSTOMER NAME</th>
											<th>EVENT STATUS</th>
											<th>DATE ADDED</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
							<div class="table-responsive">
								<table class="table table-bordered" id="planners-pending-lists"  width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>EVENT NAME</th>
											<th>EVENT PLACE</th>
											<th>EVENT DATE & TIME</th>
											<th>EVENT TYPE & PACKAGE</th>
											<th>NO OF GUESTS</th>
											<th>CUSTOMER NAME</th>
											<th>EVENT STATUS</th>
											<th>DATE ADDED</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
							<div class="table-responsive">
								<table class="table table-bordered" id="planners-inactive-lists"  width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>EVENT NAME</th>
											<th>EVENT PLACE</th>
											<th>EVENT DATE & TIME</th>
											<th>EVENT TYPE & PACKAGE</th>
											<th>NO OF GUESTS</th>
											<th>CUSTOMER NAME</th>
											<th>EVENT STATUS</th>
											<th>DATE ADDED</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
			
			<!-- /content area -->
	<!-- /page content -->
	<div id="confirmModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onclick="closePlannerModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                 <button type="button" name="ok_button" class="btn btn-danger button-delete">OK</button>
                    <button type="button" class="btn btn-default" onclick="closePlannerModal()"  data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

	<div id="restoreModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to restore this data?</h4>
                </div>
                <div class="modal-footer">
                 <button type="button" name="restore_button" id="restore_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
        @push('scripts')
		<!-- Javascript -->
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
			$(function() {
				function closePlannerModal() {
					$(".button-delete").attr("id", "");
				}
				//done 
				var planner_table_done = $("#planners-done-lists").DataTable({
					"responsive": true, 
					"lengthChange": false, 
					"autoWidth": false,
					"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
					"processing": true,
					"serverSide": true,
					ajax: {
						url: "<?= route('activeDonePlanner') ?>",
						dataType: "json",
						type: "POST",
						data: { _token: "<?= csrf_token() ?>" },
					},
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'collection',
							"text": 'Export',
							"buttons": [
								{
									"extend": 'csv',
									'title' :`DONE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'pdf',
									'title' :`DONE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'print',
									'title' :`DONE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								}
							],
						}
					],
					columns: [
						{ data: "event_name" },
						{ data: "event_venue" },
						{ data: "event_date_and_time" },
						{ data: "event_type_and_package" },
						{ data: "no_of_guests" },
						{ data: "customer_fullname" },
						{ data: "event_status" },
						{ data: "created_at" },
						{ data: "action", searchable: false, orderable: false },
					],
					"columnDefs": [
						{
							"targets": [0,1,2,3,5,6,7],   // target column
							"className": "textCenter",
						},
						{
							"targets": [4],   // target column
							"className": "textRight",
						}
					]
				});

				$(document).on("click", "#show-done-planner", function () {
					var plannerDoneId = $(this).attr("data-id");
					window.location.href = "planners/" + plannerDoneId;
				});

				$(document).on("click", "#edit-done-planner", function () {
					var id = $(this).attr("data-id");
					window.location.href = "planners/" + id + "/edit";
				});
				//end done
				//pending
				var planner_table_pending = $("#planners-pending-lists").DataTable({
					"responsive": true, 
					"lengthChange": false, 
					"autoWidth": false,
					"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
					"processing": true,
					"serverSide": true,
					ajax: {
						url: "<?= route('activePendingPlanner') ?>",
						dataType: "json",
						type: "POST",
						data: { _token: "<?= csrf_token() ?>" },
					},
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'collection',
							"text": 'Export',
							"buttons": [
								{
									"extend": 'csv',
									'title' :`PENDING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'pdf',
									'title' :`PENDING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'print',
									'title' :`PENDING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								}
							],
						}
					],
					columns: [
						{ data: "event_name" },
						{ data: "event_venue" },
						{ data: "event_date_and_time" },
						{ data: "event_type_and_package" },
						{ data: "no_of_guests" },
						{ data: "customer_fullname" },
						{ data: "event_status" },
						{ data: "created_at" },
						{ data: "action", searchable: false, orderable: false },
					],
					"columnDefs": [
						{
							"targets": [0,1,2,3,5,6,7],   // target column
							"className": "textCenter",
						},
						{
							"targets": [4],   // target column
							"className": "textRight",
						}
					]
				});

				$(document).on("click", "#show-pending-planner", function () {
					var plannerPendingId = $(this).attr("data-id");
					window.location.href = "planners/" + plannerPendingId;
				});

				$(document).on("click", "#edit-pending-planner", function () {
					var id = $(this).attr("data-id");
					window.location.href = "planners/" + id + "/edit";
				});

				var planner_pending_id;
				$(document).on("click", "#delete-pending-planner", function () {
					planner_pending_id = $(this).attr("data-id");
					$(".button-delete").attr("id", "ok_pending_button");
					$("#confirmModal").modal("show");
				});

				$(document).on("click", "#ok_pending_button",function () {
					$.ajax({
						url: "planners/destroy/" + planner_pending_id,
						beforeSend: function () {
							$("#ok_pending_button").text("Deleting...");
						},
						success: function (data) {
							$("#ok_pending_button").text("OK");
							$("#confirmModal").modal("hide");
							closePlannerModal();
							planner_table_pending.ajax.reload();
							planner_table_inactive.ajax.reload();
						},
					});
				});
				//end pending
		
				//on going
				var planner_table_ongoing = $("#planners-ongoing-lists").DataTable({
					"responsive": true, 
					"lengthChange": false, 
					"autoWidth": false,
					"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
					"processing": true,
					"serverSide": true,
					ajax: {
						url: "<?= route('activeOnGoingPlanner') ?>",
						dataType: "json",
						type: "POST",
						data: { _token: "<?= csrf_token() ?>" },
					},
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'collection',
							"text": 'Export',
							"buttons": [
								{
									"extend": 'csv',
									'title' :`ON-GOING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'pdf',
									'title' :`ON-GOING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'print',
									'title' :`ON-GOING-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								}
							],
						}
					],
					columns: [
						{ data: "event_name" },
						{ data: "event_venue" },
						{ data: "event_date_and_time" },
						{ data: "event_type_and_package" },
						{ data: "no_of_guests" },
						{ data: "customer_fullname" },
						{ data: "event_status" },
						{ data: "created_at" },
						{ data: "action", searchable: false, orderable: false },
					],
					"columnDefs": [
						{
							"targets": [0,1,2,3,5,6,7],   // target column
							"className": "textCenter",
						},
						{
							"targets": [4],   // target column
							"className": "textRight",
						}
					]
				});

				$(document).on("click", "#show-on-going-planner", function () {
					var plannerOnGoingId = $(this).attr("data-id");
					window.location.href = "planners/" + plannerOnGoingId;
				});

				$(document).on("click", "#edit-on-going-planner", function () {
					var id = $(this).attr("data-id");
					window.location.href = "planners/" + id + "/edit";
				});

				var planner_on_going_id;
				$(document).on("click", "#delete-on-going-planner", function () {
					planner_on_going_id = $(this).attr("data-id");
					$(".button-delete").attr("id", "ok_on_going_button");
					$("#confirmModal").modal("show");
				});

				$(document).on("click", "#ok_on_going_button", function () {
					$.ajax({
						url: "planners/destroy/" + planner_on_going_id,
						beforeSend: function () {
							$("#ok_on_going_button").text("Deleting...");
						},
						success: function (data) {
							$("#ok_on_going_button").text("OK");
							$("#confirmModal").modal("hide");
							closePlannerModal();
							planner_table_ongoing.ajax.reload();
							planner_table_inactive.ajax.reload();
						},
					});
				});
				//end on going
				//inactive
				var planner_table_inactive = $("#planners-inactive-lists").DataTable({
					"responsive": true, 
					"lengthChange": false, 
					"autoWidth": false,
					"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
					"processing": true,
					"serverSide": true,
					ajax: {
						url: "<?= route('inActivePlanner') ?>",
						dataType: "json",
						type: "POST",
						data: { _token: "<?= csrf_token() ?>" },
					},
					"dom": 'Bfrtip',
					"buttons": [
						{
							"extend": 'collection',
							"text": 'Export',
							"buttons": [
								{
									"extend": 'csv',
									'title' :`IN-ACTIVE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'pdf',
									'title' :`IN-ACTIVE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								},
								{
									"extend": 'print',
									'title' :`IN-ACTIVE-EVENT-LISTS`,
									"exportOptions": {
										"columns": [0,1,2,3,4,5,6,7]
									}
								}
							],
						}
					],
					columns: [
						{ data: "event_name" },
						{ data: "event_venue" },
						{ data: "event_date_and_time" },
						{ data: "event_type_and_package" },
						{ data: "no_of_guests" },
						{ data: "customer_fullname" },
						{ data: "event_status" },
						{ data: "created_at" },
						{ data: "action", searchable: false, orderable: false },
					],
					"columnDefs": [
						{
							"targets": [0,1,2,3,5,6,7],   // target column
							"className": "textCenter",
						},
						{
							"targets": [4],   // target column
							"className": "textRight",
						}
					]
				});

				//restore
				var plannerId;
				$(document).on('click', '#restore-planner', function(){
					plannerId = $(this).attr('data-id');
					$('#restoreModal').modal('show');
				});

				$('#restore_button').click(function(){
					$.ajax({
						url:"planners/restore/"+plannerId,
						beforeSend:function(){
							$('#restore_button').text('Restoring...');
						},
						success:function(data)
						{
							setTimeout(function(){
								$('#restoreModal').modal('hide');
								planner_table_inactive.ajax.reload();
								planner_table_done.ajax.reload();
								planner_table_ongoing.ajax.reload();
								planner_table_pending.ajax.reload();
								$('#restore_button').text('OK');
							}, 2000);
						}
					})
				});
				//end inactive
			});
		</script>
        @endpush('scripts')
@endsection