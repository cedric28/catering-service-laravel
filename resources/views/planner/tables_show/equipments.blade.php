<div class="table-responsive">
    <table class="table table-bordered" id="planner-equipments-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>EQUIPMENT NAME</th>
                <th>REQUIRED QUANTITY</th>
                <th>CURRENT QUANTITY</th>
                <th>RETURNED QUANTITY</th>
                <th>REMARKS</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    var tablePlannerEquipment = $('#planner-equipments-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerEquipment') ?>",
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
                        //     'title' :`EVENT-${event_name}-EQUIPMENT-LISTS`,
                        //     "exportOptions": {
                        //         "columns": [0,1,2,3]
                        //     }
                        // },
                        // {
                        //     "extend": 'pdf',
                        //     'title' :`EVENT-${event_name}-EQUIPMENT-LISTS`,
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
                                                <h2>EVENT-${event_name}-EQUIPMENT-LISTS</h2>
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
                { data: "equipment_name" },
                { data: "required_quantity" },
                { data: "current_quantity" },
                { data: "returned_quantity" },
                { data: "remarks" },
                { data: "status" },
            ],
            "columnDefs": [
                {
                    "targets": [0,4,5],   // target column
                    "className": "textCenter",
                },
                {
                    "targets": [1,2,3],   // target column
                    "className": "textRight",
                }
            ]
        });


        $(document).on('click', '#delete-planner-equipment', function(){
            let planner_equipment_id = $(this).attr('data-id');
            console.log(planner_equipment_id);
            $.ajax({
                url:"<?= route('destroyEquipment') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_equipment_id,
                },
                success:function(data)
                {
                    console.log(data);
                    tablePlannerEquipment.ajax.reload();
                }
            })
        });
</script>
@endpush('scripts')