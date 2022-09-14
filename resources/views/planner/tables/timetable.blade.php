@if($planner->status != 'done')
<form action="{{ route('storeTimeTable')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <!-- <div class="form-group row" id="tasks_dropdown">
        <label class="col-lg-3 col-form-label">Tasks:</label>
        <div class="col-lg-9">
            <select id="task_time_table_id" name="task_name_time_table" class="@error('task_name_time_table') is-invalid @enderror form-control select2">
                <option value="">Select Task</option>
                @foreach ($time_tables_lists as $time)
                    <option value="{{ $time['task_name'] }}" {{ ($time['task_name'] == old("task_name_time_table")) ? " selected" : "" }}>{{ ucwords($time['task_name']) }}</option>
                @endforeach
            </select>
        </div>
    </div> -->
    <div class="form-group row" id="tasks_input">
        <label class="col-lg-3 col-form-label">Tasks:</label>
        <div class="col-lg-9">
            <input type="text" name="task_name" value="{{ old('task_name') }}" class="@error('task_name') is-invalid @enderror form-control" placeholder="e.g Dinner">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Time:</label>
        <div class="col-lg-9">
        <div class="input-group date" id="timetable" data-target-input="nearest">
            <input type="text" name="task_time" value="{{ old('task_time') }}" placeholder="e.g 8:27 PM" onkeydown="return false;" class="@error('task_time') is-invalid @enderror form-control datetimepicker-input" data-target="#timetable"/>
            <div class="input-group-append" data-target="#timetable" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
@endif
<div class="table-responsive">
    <table class="table table-bordered" id="planner-time-table-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>TIME</th>
                <th>TASK</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    // var selected_option_time = $('#task_time_table_id option:selected').val();
    // $('#task_time_table_id').on('change', function(){
    //     console.log($(this).is(':selected'));
    //     // if($(this).is(':selected').val() != ""){
    //     //     console.log("may laman")
    //     // } else{
    //     //     console.log("walang laman")
    //     // }
    // });
   
    var tablePlannerTimeTable = $('#planner-time-table-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerTimeTable') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{
                    "_token":"<?= csrf_token() ?>",
                    "planner_id": planner_id,
                    "planner_show" : planner_show
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
                            'title' :`EVENT-${event_name}-TIME-TABLE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-TIME-TABLE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-TIME-TABLE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        }
                    ],
                }
            ],
            columns: [
                { data: "task_time" },
                { data: "task_name" },
                { data: "action", searchable: false, orderable: false },
            ],
            "columnDefs": [
                {
                    "targets": [0,1,2],   // target column
                    "className": "textCenter",
                }
            ]
        });


        $(document).on('click', '#delete-planner-time-table', function(){
            let planner_time_table_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyTimeTable') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_time_table_id,
                },
                success:function(data)
                {
                    tablePlannerTimeTable.ajax.reload();
                }
            })
            
        });
</script>
@include('planner.modals.timetable_modal')
@endpush('scripts')