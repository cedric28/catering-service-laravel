<div class="table-responsive">
    <table class="table table-bordered" id="planner-staffings-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>NAME</th>
                <th>DUTY</th>
                <th>ATTENDANCE</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>NAME</th>
                <th>DUTY</th>
                <th>ATTENDANCE</th>
            </tr>
        </tfoot>
    </table>
</div>

@push('scripts')
<script>
    var tablePlannerStaffing = $('#planner-staffings-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerStaffing') ?>",
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
                            'title' :`EVENT-${event_name}-EMPLOYEE-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-EMPLOYEE-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-EMPLOYEE-STAFF-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        }
                    ],
                }
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? val : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            columns: [
                { data: "fullname" },
                { data: "job_type" },
                { data: "attendance" },
            ],
            "columnDefs": [
                {
                    "targets": [0,1],   // target column
                    "className": "textCenter",
                }
            ]
        });


        $(document).on('click', '#delete-planner-staffing', function(){
            let planner_staffing_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyStaffing') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_staffing_id,
                },
                success:function(data)
                {
                    tablePlannerStaffing.ajax.reload();
                    location.reload();
                }
            })
            
        });

        $(document).on('click', '#edit-planner-staffing', function(){
            let planner_staffing_id = $(this).attr('data-id');
            let planner_staffing_attendance = $(this).attr('data-attendance');
            $.ajax({
                url:"<?= route('changeAttendanaceStaffing') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_staffing_id,
                    "attendance" : planner_staffing_attendance
                },
                success:function(data)
                {
                    tablePlannerStaffing.ajax.reload();
                }
            })
            
        });
</script>
@endpush('scripts')