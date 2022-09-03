<form action="{{ route('storePayment')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Payment Type:</label>
        <div class="col-lg-9">
            <select id="payment_type" name="payment_type" class="@error('payment_type') is-invalid @enderror form-control select2">
                <option value="">Select Payment Method</option>
                @foreach ($paymentTypes as $type)
                    <option value="{{ $type->name }}" {{ ($type->name == old("payment_type")) ? " selected" : "" }}>{{ ucwords($type->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Payment Price:</label>
        <div class="col-lg-9">
            <input type="text" name="payment_price" value="{{ old('payment_price') }}" class="@error('payment_price') is-invalid @enderror form-control" placeholder="e.g 1000">
        </div>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
    </div>
    </form>
    <div class="table-responsive">
    <table class="table table-bordered" id="planner-payment-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>PAYMENT METHOD</th>
                <th>FEE</th>
                <th>DATE ADDED</th>
                <th>ACTION</th>
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
                { data: "action", searchable: false, orderable: false },
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