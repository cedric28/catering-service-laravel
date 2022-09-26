<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-tasks-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>TITLE</th>
                <th>DATE & TIME</th>
                <th>TYPE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
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
                        {
                            "extend": 'csv',
                            'title' :`EVENT-${event_name}-TASKS-LISTS`,
                            "messageTop": 'Task: ',
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-TASKS-LISTS`,
                            "messageTop": 'Task: ',
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-TASKS-LISTS`,
                            "messageTop": 'Task: ',
                            "exportOptions": {
                                "columns": [0,1,2,3]
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
@endpush('scripts')