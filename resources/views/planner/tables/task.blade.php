@if($planner->status != 'completed' && Auth::user()->job_type_id == 1)
<form action="{{ route('storeTask')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Title:</label>
        <div class="col-lg-9">
            <select id="package_task_id" name="package_task_id" class="@error('package_task_id') is-invalid @enderror form-control select2">
                <option value="">Select Task</option>
                @foreach ($package_tasks as $task)
                    <option value="{{ $task->id }}"{{ ($task->id == old('package_task_id')) ? ' selected' : '' }}>{{ ucwords($task->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Date & Time:</label>
        <div class="col-lg-9">
        <div class="input-group date" id="taskdate" data-target-input="nearest">
            <input type="text" name="task_date" value="{{ old('task_date') }}" placeholder="e.g 2022-08-20 8:27 PM" onkeydown="return false;" class="@error('task_date') is-invalid @enderror form-control datetimepicker-input" data-target="#taskdate"/>
            <div class="input-group-append" data-target="#taskdate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Task Type:</label>
        <div class="col-lg-9">
            <select id="task_type" name="task_type" class="@error('task_type') is-invalid @enderror form-control select2">
                <option value="">Select Type</option>
                @foreach ($task_types as $task_type)
                    <option value="{{ $task_type['type'] }}" {{ ($task_type["type"] == old("task_type")) ? " selected" : "" }}>{{ ucwords($task_type['type']) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
@endif
<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-tasks-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>TITLE</th>
                <th>DATE & TIME</th>
                <th>TYPE</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    let logo = window.location.origin + '/assets/img/logo-pink.png';
    let user_login = {!! json_encode( ucwords(Auth::user()->name)) !!};
    let dateToday = new Date();
    var tablePlannerTask = $('#planner-package-tasks-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerTask') ?>",
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
                        // {
                        //     "extend": 'csv',
                        //     'title' :`EVENT-${event_name}-TASKS-LISTS`,
                        //     "messageTop": 'Task: ',
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3]
                        //     }
                        // },
                        // {
                        //     "extend": 'pdf',
                        //     'title' :`EVENT-${event_name}-TASKS-LISTS`,
                        //     "messageTop": 'Task: ',
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3]
                        //     }
                        // },
                        {
                            "extend": 'print',
                            'title' :``,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            },
                            "customize": function ( win ) {
                                $(win.document.body)
                                    .css( 'font-size', '10pt' )
                                    .prepend(
                                        `
                                        <div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
                                            <div class="title-header">
                                                <h2>EVENT-${event_name}-TASKS-LISTS</h2>
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
            columns: [
                { data: "task_name" },
                { data: "task_date_and_time" },
                // { data: "staffs" },
                { data: "task_type" },
                { data: "task_status" },
                { data: "action", searchable: false, orderable: false },
            ],
            "columnDefs": [
                {
                    "targets": [0,1,2,3],   // target column
                    "className": "textCenter",
                }
            ]
        });


        $(document).on('click', '#delete-planner-task', function(){
            let planner_task_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyTask') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_task_id,
                },
                success:function(data)
                {
                    tablePlannerTask.ajax.reload();
                }
            })
        });
</script>
@include('planner.modals.configurestaff')
@include('planner.modals.task_modal')
@endpush('scripts')