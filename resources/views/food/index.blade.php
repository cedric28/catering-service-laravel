@extends('layouts.app')

@section('content')

	<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Foods</span></h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
					<a href="{{ route('foods.index')}}" class="breadcrumb-item">Foods</a>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a type="button" href="{{ route('foods.create')}}" class="btn btn-outline-success btn-sm float-left"><i class="icon-add mr-2"></i> Add Food</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="foods-lists"  width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>FOOD NAME</th>
							<th>FOOD CATEGORY</th>
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
			
			<!-- /content area -->
	<!-- /page content -->
	<div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                 <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
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

			var table = $('#foods-lists').DataTable({
				"responsive": true, 
				"lengthChange": false, 
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('activeFood') ?>",
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
								"extend": 'csv',
								'title' :`FOOD-LISTS`,
								"exportOptions": {
									"columns": [0,1,2]
								}
							},
							{
								"extend": 'pdf',
								'title' :`FOOD-LISTS`,
								"exportOptions": {
									"columns": [0,1,2]
								}
							},
							{
								"extend": 'print',
								'title' :`FOOD-LISTS`,
								"exportOptions": {
									"columns": [0,1,2]
								}
							}
						],
					}
				],
				"columns":[
					{"data":"name"},
					{"data":"food_category_name"},
					{"data":"created_at"},
					{"data":"action","searchable":false,"orderable":false}
				],
				"columnDefs": [
					{
						"targets": [0,1,2],   // target column
						"className": "textCenter",
					}
				]
			});

			$(document).on('click', '#show', function(){
				var foodId = $(this).attr('data-id');
				window.location.href = 'foods/'+foodId;
			});

			$(document).on('click', '#edit', function(){
				var id = $(this).attr('data-id');
				window.location.href = 'foods/'+id+'/edit';
			});

			var food_id;
			$(document).on('click', '#delete', function(){
				food_id = $(this).attr('data-id');
				$('#confirmModal').modal('show');
			});

			$('#ok_button').click(function(){
				$.ajax({
					url:"foods/destroy/"+food_id,
					beforeSend:function(){
						$('#ok_button').text('Deleting...');
					},
					success:function(data)
					{
						setTimeout(function(){
							$('#confirmModal').modal('hide');
							table.ajax.reload();
						}, 2000);
					}
				})
			});
		</script>
        @endpush('scripts')
@endsection