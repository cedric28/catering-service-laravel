@extends('layouts.app')

@section('content')
		<!-- Page Heading -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title d-flex">
					<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Users</span></h4>
					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>

			<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
				<div class="d-flex">
					<div class="breadcrumb">
						<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
						<a href="{{ route('users.index')}}" class="breadcrumb-item"> Users</a>
					</div>

					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>
		</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<a type="button" href="{{ route('users.create')}}" class="btn btn-outline-success btn-sm float-left"><i class="fas fa-fw fa-plus"></i> Add User</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="user-lists" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>FULLNAME</th>
							<th>EMAIL</th>
							<th>ROLE</th>
							<th>JOB TYPE</th>
							<th>DATE ADDED</th>
							<th>ACTION</th>
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
	
		<!-- Page level custom scripts -->
		<script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>
		<script>

			var table = $('#user-lists').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url":"<?= route('activeUser') ?>",
					"dataType":"json",
					"type":"POST",
					"data":{"_token":"<?= csrf_token() ?>"}
				},
				"columns":[
					{"data":"name"},
					{"data":"email"},
					{"data":"role"},
					{"data":"job_type"},
					{"data":"created_at"},
					{"data":"action","searchable":false,"orderable":false}
				]
			});

			$(document).on('click', '#show', function(){
				var userId = $(this).attr('data-id');
				window.location.href = 'users/'+userId;
			});

			$(document).on('click', '#edit', function(){
				var id = $(this).attr('data-id');
				window.location.href = 'users/'+id+'/edit';
			});

			var user_id;
			$(document).on('click', '#delete', function(){
				user_id = $(this).attr('data-id');
				$('#confirmModal').modal('show');
			});

			$('#ok_button').click(function(){
				$.ajax({
					url:"users/destroy/"+user_id,
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
