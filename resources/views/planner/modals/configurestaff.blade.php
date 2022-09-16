<div id="configureStaffModal" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center" class="w-100"><span>Task Staff Settings</span></h4>
                <button type="button" class="close float-right" onclick="closeTaskStaffModal()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="taskStaffData">
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalTaskStaffError"></span></h5>
                    <input type="hidden" id="planner_task_id" name="planner_task_id" value="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Staff:</label>
                        <div class="col-lg-9">
                            <select id="select_user_id" name="user_id" class="@error('select_user_id') is-invalid @enderror form-control select2">
                                <option value="">Select Staff</option>
                                @foreach ($usersHeadStaff as $user)
                                    <option value="{{ $user->id }}"{{ ($user->id == old('user_id')) ? ' selected' : '' }}>{{ ucwords($user->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" name="add_task_staff_button" id="add_task_staff_button" class="btn btn-primary ml-auto">Add</button>
                    </div>
                </form>
                <hr/>
                <div class="table-responsive">
                    <table class="table table-bordered" id="planner-tasks-staff-lists"  width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closeTaskStaffModal()" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    //add task staff
    var tableTaskStaff;
        $(document).on('click', '#setting-planner-task-staff', function(event){
            event.preventDefault();
            let plannerTaskId = $(this).attr('data-id');
            $('#planner_task_id').val(plannerTaskId);
            $('#configureStaffModal').modal('show');

            tableTaskStaff = $('#planner-tasks-staff-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerTaskStaff') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{
                    "_token":"<?= csrf_token() ?>",
                    "planner_task_id": plannerTaskId,
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
                            'title' :`EVENT-${event_name}-TASKS-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-TASKS-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-TASKS-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        }
                    ],
                }
            ],
            "columns": [
                { data: "name" },
                { data: "action", searchable: false, orderable: false },
            ],
            "columnDefs": [
                {
                    "targets": [0],   // target column
                    "className": "textCenter",
                },
                {
                    "targets": [1],   // target column
                    "className": "textRight",
                }
            ]
        });
        });
        
      

        $(document).on('click', '#delete-planner-task-staff', function(){
            let planner_task_staff_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyTaskStaff') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_task_staff_id,
                },
                success:function(data)
                {
                    tableTaskStaff.ajax.reload();
                }
            })
            
        });

        function closeTaskStaffModal() {
            $('#add_task_staff_button').text('Add');
            $("#taskStaffData").trigger("reset");
            $("#taskStaffData input:hidden").val("");
            $("#select_user_id").removeClass("is-invalid");
            $('#generalTaskStaffError').text("");
            tableTaskStaff.destroy();
            location.reload();
        }

        $(document).on('click','#add_task_staff_button', function(event){
            event.preventDefault();
            let selected_user_id = $( "#select_user_id option:selected").val();
            let plannerTaskId = $("#planner_task_id").val();
            console.log(selected_user_id);
            $.ajax({
                url:"<?= route('storeTaskStaff') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "user_id": selected_user_id,
                    "planner_task_id": plannerTaskId,
                },
                beforeSend:function(){
                    $('#add_task_staff_button').text('Saving...');
                },
                success:function(data)
                {
                    $("#taskStaffData").trigger("reset");
                    // $('#configureStaffModal').modal('hide');
                    $('#add_task_staff_button').text('Add');
                    $("#select_user_id").removeClass("is-invalid");
                    $('#generalTaskStaffError').text("");
                    $(`select[name^="select_user_id"] option:selected`).removeAttr("selected");
                    tableTaskStaff.ajax.reload();
                },
                error:function(err){
                    if(err.responseJSON){
                        let receivedMessage = err.responseJSON.data;
                        if(receivedMessage.user_id){
                            $('#generalTaskStaffError').text(receivedMessage.user_id[0]);
                            $("#select_user_id").addClass("is-invalid");
                        }else{
                            $('#generalTaskStaffError').text("");
                            $("#select_user_id").removeClass("is-invalid");
                        }
                        
                        $('#add_task_staff_button').text('Add');
                    }
                }
            })
        });
    
</script>
@endpush('scripts')