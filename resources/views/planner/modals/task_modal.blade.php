<!--- Add Task Modal -->
<div id="editPlannerTaskModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="plannerTaskData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="plannerTaskTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closePlannerTaskModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="my_planner_id" name="planner_id" value=""/>
                    <input type="hidden" id="planner_task_ids" name="planner_task_id" value="">
                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="planner_package_task_id_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Tasks:</label>
                        <div class="col-lg-9">
                            <select id="planner_package_task_id" name="planner_package_task_id" class="@error('planner_package_task_id') is-invalid @enderror form-control select2">
                                <option value="">Select Task</option>
                                @foreach ($package_tasks as $task)
                                    <option value="{{ $task->id }}">{{ ucwords($task->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="plannertaskdate_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Task Date & Time:</label>
                        <div class="col-lg-9">
                            <div class="input-group date" id="plannertaskdate" data-target-input="nearest">
                                <input type="text" id="edit-planner-task-date-time" name="plannertaskdate" value="{{ old('plannertaskdate') }}" placeholder="e.g 2022-08-20 8:27 PM" onkeydown="return false;" class="@error('plannertaskdate') is-invalid @enderror form-control datetimepicker-input" data-target="#plannertaskdate"/>
                                <div class="input-group-append" data-target="#plannertaskdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="planner_task_type_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Task Type:</label>
                        <div class="col-lg-9">
                            <select id="planner_task_type" name="planner_task_type" class="@error('planner_task_type') is-invalid @enderror form-control select2">
                                <option value="">Select Type</option>
                                @foreach ($task_types as $task_type)
                                    <option value="{{ $task_type['type'] }}">{{ ucwords($task_type['type']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="planner_task_status_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Status:</label>
                        <div class="col-lg-9">
                            <select id="planner_task_status" name="planner_task_status" class="@error('planner_task_status') is-invalid @enderror form-control select2">
                                <option value="">Select Status</option>
                                @foreach($taskStatus as $stat)

                                    <option value="{{ $stat['status'] }}">{{ ucwords($stat['status']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="update_planner_task_button" id="update_planner_task_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closePlannerTaskModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>

    $(document).on('click', '#edit-planner-task', function(event){
        event.preventDefault();
        $('#plannerTaskTitle').html(`Update Task Detail`);
        let myPlannerId = $(this).attr('data-my-planner-id');
        let plannerTaskId = $(this).attr('data-id');
        let packageTaskId = $(this).attr('data-package-task-id');
        let plannerTaskType = $(this).attr('data-task-type');
        let plannerTaskStatus = $(this).attr('data-status');
        let plannerTaskDate = $(this).attr('data-event-date');
        let plannerTaskTime = $(this).attr('data-event-time');
        $('#planner_task_ids').val(plannerTaskId);
        $('#my_planner_id').val(myPlannerId);
        $('#edit-planner-task-date-time').val(`${plannerTaskDate} | ${plannerTaskTime}`);
        $(`select[name^="planner_package_task_id"] option[value=${packageTaskId}]`).attr("selected","selected");
        $(`select[name^="planner_task_type"] option[value=${plannerTaskType}]`).attr("selected","selected");
        $(`select[name^="planner_task_status"] option[value=${plannerTaskStatus}]`).attr("selected","selected");
        $('#editPlannerTaskModal').modal('show');
    });


    function closePlannerTaskModal() {
        $("#plannerTaskData").trigger("reset");
        $('#update_planner_task_button').text('OK');
        $("#plannerTaskData input:hidden").val("");
        $("#planner_package_task_id").removeClass("is-invalid");
        $("#edit-planner-task-date-time").removeClass("is-invalid");
        $("#planner_task_type").removeClass("is-invalid");
        $("#planner_task_status").removeClass("is-invalid");

        $('#planner_package_task_id_error').text("");
        $('#plannertaskdate_error').text("");
        $('#planner_task_type_error').text("");
        $('#planner_task_status_error').text("");
        $(`select[name^="planner_package_task_id"] option:selected`).removeAttr("selected");
        $(`select[name^="planner_task_type"] option:selected`).removeAttr("selected");
        $(`select[name^="planner_task_status"] option:selected`).removeAttr("selected");
    }

    $(document).on('click','#update_planner_task_button',function(event){
        event.preventDefault();
        let my_planner_id = $("#my_planner_id").val();
        let planner_task_ids = $("#planner_task_ids").val();
        let planner_package_task_id = $("#planner_package_task_id option:selected" ).val();
        let plannertaskdate = $('#edit-planner-task-date-time').val();
        let planner_task_type = $("#planner_task_type option:selected" ).val();
        let planner_task_status = $("#planner_task_status option:selected" ).val();

        console.log({
            my_planner_id,
            planner_task_ids,
            plannertaskdate
        })
        $.ajax({
            url:"<?= route('updateTask') ?>",
            dataType:"json",
            type:"POST",
            data:{
                "_token":"<?= csrf_token() ?>",
                "planner_id": my_planner_id,
                "planner_task_ids": planner_task_ids,
                "package_task_id" : planner_package_task_id,
                "task_date": plannertaskdate,
                "task_type": planner_task_type,
                "task_status" : planner_task_status
            },
            beforeSend:function(){
                $('#update_planner_task_button').text('Saving...');
            },
            success:function(data)
            {
                $("#plannerTaskData").trigger("reset");
                $('#editPlannerTaskModal').modal('hide');
                $("#plannerTaskData").trigger("reset");
                $('#update_planner_task_button').text('OK');
                $("#plannerTaskData input:hidden").val("");
                $("#planner_package_task_id").removeClass("is-invalid");
                $("#edit-planner-task-date-time").removeClass("is-invalid");
                $("#planner_task_type").removeClass("is-invalid");
                $("#planner_task_status").removeClass("is-invalid");
                tablePlannerTask.ajax.reload();
                $('#planner_package_task_id_error').text("");
                $('#plannertaskdate_error').text("");
                $('#planner_task_type_error').text("");
                $('#planner_task_status_error').text("");
                $(`select[name^="planner_package_task_id"] option:selected`).removeAttr("selected");
                $(`select[name^="planner_task_type"] option:selected`).removeAttr("selected");
                $(`select[name^="planner_task_status"] option:selected`).removeAttr("selected");
            },
            error:function(err){
                if(err.responseJSON){
                    let receivedMessage = err.responseJSON.data;
                    
                    if(receivedMessage.package_task_id){
                        $('#planner_package_task_id_error').text(receivedMessage.package_task_id[0]);
                        $("#planner_package_task_id").addClass("is-invalid");
                    } else {
                        $('#planner_package_task_id_error').text("");
                        $("#planner_package_task_id").removeClass("is-invalid");
                    }

                    if(receivedMessage.task_date){
                        console.log(receivedMessage.task_date);
                        $('#plannertaskdate_error').text(receivedMessage.task_date[0]);
                        $("#edit-planner-task-date-time").addClass("is-invalid");
                    }else {
                        $('#plannertaskdate_error').text("");
                        $("#edit-planner-task-date-time").removeClass("is-invalid");
                    }

                    if(receivedMessage.task_type){
                        $('#planner_task_type_error').text(receivedMessage.task_type[0]);
                        $("#planner_task_type").addClass("is-invalid");
                    } else {
                        $('#planner_task_type_error').text("");
                        $("#planner_task_type").removeClass("is-invalid");
                    }

                    if(receivedMessage.task_status){
                        $('#planner_task_status_error').text(receivedMessage.task_status[0]);
                        $("#planner_task_status").addClass("is-invalid");
                    } else {
                        $('#planner_task_status_error').text("");
                        $("#planner_task_status").removeClass("is-invalid");
                    }
                    $('#update_planner_task_button').text('Save');
                }
            }
        })
    });
</script>
@endpush('scripts')