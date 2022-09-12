<div class="table-responsive">
    <table class="table table-bordered" id="planner-package-others-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>SERVICE</th>
                <th>SERVICE FEE</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    var tablePlannerOther = $('#planner-package-others-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerOther') ?>",
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
                            'title' :`EVENT-${event_name}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1]
                            }
                        }
                    ],
                }
            ],
            columns: [
                { data: "name" },
                { data: "service_price" },
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


        $(document).on('click', '#delete-planner-other', function(){
            let planner_other_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyOther') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_other_id,
                },
                success:function(data)
                {
                    tablePlannerOther.ajax.reload();
                }
            })
            
        });
</script>
@endpush('scripts')