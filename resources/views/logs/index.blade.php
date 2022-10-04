@extends('layouts.app')

@section('content')
		<!-- Page Heading -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title d-flex">
					<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">System Logs</span></h4>
					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>

			<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
				<div class="d-flex">
					<div class="breadcrumb">
						<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
						<a href="{{ route('logs.index')}}" class="breadcrumb-item"> System Logs</a>
					</div>

					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>
		</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
		
		</div>
		<div class="card-body">
			<div class="card shadow card-primary card-outline card-outline-tabs border-top-primary">
				<div class="card-header p-0 border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Active Logs</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="custom-tabs-four-tabContent">
						<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<div class="table-responsive">
								<table class="table table-bordered" id="logs" width="100%" cellspacing="0">
									<thead>
										<tr style="text-align:center;">
											<th>LOG</th>
											<th>TRANSACTION DATE</th>
										</tr>
									</thead>

									<tbody>
										<tr>
											
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
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
			let logo = window.location.origin + '/assets/img/logo-pink.png';
			let user_login = {!! json_encode( ucwords(Auth::user()->name)) !!};
			let dateToday = new Date();
			var table = $('#logs').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('activityLogs') ?>",
					"dataType":"json",
					"type":"POST",
					"data":{"_token":"<?= csrf_token() ?>"}
				},
				"dom": 'Bfrtip',
				"buttons": [
					{
						"extend": 'collection',
						"text": 'Export',
						"buttons": [
						
							{
								"extend": 'print',
								'title' : ``,
								"exportOptions": {
									"columns": [0,1]
								},
								"customize": function ( win ) {
									$(win.document.body)
										.css( 'font-size', '10pt' )
										.prepend(
											`
											<div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
												<div class="title-header">
													<h2>SYSTEM-LOGS</h2>
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
                    {"data":"log"},
                    {"data":"created_at"}
                ],
                "columnDefs": [
				{
					"targets": [1],   // target column
					"className": "textCenter",
				}]
			});

			

		
		</script>
	@endpush('scripts')
@endsection
