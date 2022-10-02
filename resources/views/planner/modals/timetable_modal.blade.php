<!--- Add Task Modal -->
<div id="editTimeTableModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="timeTableData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="timeTableTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closeTimeTableModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="time_table_id" name="time_table_id" value="">
                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="time_table_time_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Task Time:</label>
                        <div class="col-lg-9">
                        <div class="input-group date" id="timetable_update" data-target-input="nearest">
                            <input type="text" id="timetable_task_time" name="update_task_time" value="{{ old('update_task_time') }}" placeholder="e.g 8:27 PM" onkeydown="return false;" class="@error('update_task_time') is-invalid @enderror form-control datetimepicker-input" data-target="#timetable_update"/>
                            <div class="input-group-append" data-target="#timetable_update" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="update_time_table" id="update_time_table" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closeTimeTableModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    function closeTimeTableModal() {
        $("#timeTableData").trigger("reset");
        $('#update_time_table').text('OK');
        $("#timeTableData input:hidden").val("");
        $('#time_table_time_error').text("");
        $("#timetable_task_time").removeClass("is-invalid");
    }

    $(document).on('click', '#edit-planner-time-table', function(event){
        event.preventDefault();
        $('#timeTableTitle').html(`Update Time`);
        let timeTableId = $(this).attr('data-id');
        let timeTableTaskTime = $(this).attr('data-time');
        $('#time_table_id').val(timeTableId);
        $('#timetable_task_time').val(timeTableTaskTime);
        $('#editTimeTableModal').modal('show');
    });

    $(document).on('click','#update_time_table',function(event){
        event.preventDefault();
        let time_table_id = $("#time_table_id").val();
        let task_time = $("#timetable_task_time").val();
        console.log({
            time_table_id,
            task_time,
        });
        $.ajax({
            url:"<?= route('updateTimeTable') ?>",
            dataType:"json",
            type:"POST",
            data:{
                "_token":"<?= csrf_token() ?>",
                "time_table_id": time_table_id,
                "task_time": task_time,
                "planner_id" : planner_id
            },
            beforeSend:function(){
                $('#update_time_table').text('Saving...');
            },
            success:function(data)
            {
                $("#timeTableData").trigger("reset");
                $('#editTimeTableModal').modal('hide');
                $('#update_time_table').text('OK');
                $("#timeTableData input:hidden").val("");
           
                tablePlannerTimeTable.ajax.reload();
                $('#time_table_time_error').text("");
                $("#timetable_task_time").removeClass("is-invalid");
            },
            error:function(err){
                if(err.responseJSON){
                    let receivedMessage = err.responseJSON.data;
                    if(receivedMessage.task_time){
                        $('#time_table_time_error').text(receivedMessage.task_time[0]);
                        $("#timetable_task_time").addClass("is-invalid");
                    }else {
                        $('#time_table_time_error').text("");
                        $("#timetable_task_time").removeClass("is-invalid");
                    }

                    $('#update_time_table').text('Save');
                }
            }
        })
    });

    $(document).ready(function() {
		let bindTimeTableUpdatePicker = function() {
			$("#timetable_update").datetimepicker({
					showClear: true,
					showClose: true,
					allowInputToggle: true,
					useCurrent: false,
					ignoreReadonly: true,
					format:'hh:mm A',
				});
		}
		bindTimeTableUpdatePicker();
 	});
</script>
@endpush('scripts')