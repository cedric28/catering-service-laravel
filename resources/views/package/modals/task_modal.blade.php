<!--- Add Task Modal -->
<div id="addTaskModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="taskData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="taskTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closeModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalError"></span></h5>
                    <input type="hidden" id="task_id" name="task_id" value="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Task:</label>
                        <div class="col-lg-9 col-sm-9">	
                            <input type="text" id="task-name" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="e.g Digital Photography" >
                        </div>
                    </div>			
                </div>
                <div class="modal-footer">
                <button type="button" name="add_button" id="add_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closeModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    var table = $('#package-tasks-lists').DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url":"<?= route('activePackageTask') ?>",
            "dataType":"json",
            "type":"POST",
            "data":{
                "_token":"<?= csrf_token() ?>",
                "package_id": packageId
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
                        'title' :`PACKAGE-${packageName}-TASK-LISTS`,
                        "exportOptions": {
                            "columns": [0,1]
                        }
                    },
                    {
                        "extend": 'pdf',
                        'title' :`PACKAGE-${packageName}-TASK-LISTS`,
                        "exportOptions": {
                            "columns": [0,1]
                        }
                    },
                    {
                        "extend": 'print',
                        'title' :`PACKAGE-${packageName}-TASK-LISTS`,
                        "exportOptions": {
                            "columns": [0,1]
                        }
                    }
                ],
            }
        ],
        "columns":[
            {"data":"name"},
            {"data":"created_at"},
            {"data":"action","searchable":false,"orderable":false}
        ],
        "columnDefs": [
        {
            "targets": [0,1],   // target column
            "className": "textCenter",
        }
        ]
    });

    function closeModal() {
      
            $("#taskData").trigger("reset");
            $("#taskData input:hidden").val(' ');
            $("#task-name").removeClass("is-invalid");
            $('#generalError').text("");
    
    }

    $(document).on('click', '#add-task', function(event){
        event.preventDefault();
        $('#taskTitle').html("Add New Task");
        $('#addTaskModal').modal('show');
    });

    $(document).on('click', '#edit', function(event){
        event.preventDefault();
        $('#taskTitle').html("Update Task Detail");
        let taskId = $(this).attr('data-id');
        let taskName = $(this).attr('data-name');
        $('#task_id').val(taskId);
        $('#task-name').val(taskName);
        $('#addTaskModal').modal('show');
    });

    $('#add_button').click(function(event){
        event.preventDefault();
        let name = $("#task-name").val();
        let task_id = $("#task_id").val();
        console.log({
            name,
            task_id
        })
        $.ajax({
            url:"<?= route('addTask') ?>",
            dataType:"json",
            type:"POST",
            data:{
                "_token":"<?= csrf_token() ?>",
                "name": name,
                "package_id": packageId,
                "task_id": task_id
            },
            beforeSend:function(){
                $('#add_button').text('Saving...');
            },
            success:function(data)
            {
              
                    $("#taskData").trigger("reset");
                    $('#addTaskModal').modal('hide');
                    table.ajax.reload();
                    $('#add_button').text('OK');
                    $("#taskData input:hidden").val(' ');
                    $("#task-name").removeClass("is-invalid");
                    $('#generalError').text("");
            
                
            },
            error:function(err){
                if(err.responseJSON){
                    let receivedMessage = err.responseJSON.data;
                    $('#generalError').text(receivedMessage.name[0]);
                    $("#task-name").addClass("is-invalid");
                    $('#add_button').text('Save');
                }
            }
        })
    });
</script>
@endpush('scripts')