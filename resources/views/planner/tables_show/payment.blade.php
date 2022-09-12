<div class="table-responsive">
    <table class="table table-bordered" id="planner-payment-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>PAYMENT METHOD</th>
                <th>FEE</th>
                <th>DATE ADDED</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    var tablePlannerPayment = $('#planner-payment-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePlannerPayments') ?>",
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
                            'title' :`EVENT-${event_name}-PAYMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-PAYMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-PAYMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        }
                    ],
                }
            ],
            columns: [
                { data: "payment_type" },
                { data: "payment_price" },
                { data: "created_at" },
            ],
            "columnDefs": [
                {
                    "targets": [0,2],   // target column
                    "className": "textCenter",
                },
                {
                    "targets": [1],   // target column
                    "className": "textRight",
                }
            ]
        });


        $(document).on('click', '#delete-planner-time-table', function(){
            let planner_payment_id = $(this).attr('data-id');
            $.ajax({
                url:"<?= route('destroyPayment') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "id": planner_payment_id,
                },
                success:function(data)
                {
                    tablePlannerPayment.ajax.reload();
                }
            })
            
        });
</script>
@endpush('scripts')