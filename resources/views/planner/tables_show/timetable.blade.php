<div class="table-responsive">
    <table class="table table-bordered" id="planner-time-table-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>TIME</th>
                <th>TASK</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
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
            ],
            "columnDefs": [
                {
                    "targets": [0,1],   // target column
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
@endpush('scripts')