@if($planner->status != 'completed')

<div class="row">
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This is for the Birthday Package only.
        </div>
    </div>
</div>
        
<form action="{{ route('storeOther')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Service:</label>
        <div class="col-lg-9">
            <select id="package_other_id" name="package_other_id" class="@error('package_other_id') is-invalid @enderror form-control select2">
                <option value="">Select Service</option>
                @foreach ($package_others as $package_other)
                    <option value="{{ $package_other->id }}" {{ ($package_other->id == old("package_other_id")) ? " selected" : "" }}>{{ ucwords($package_other->name) }} - {{ Str::currency($package_other->service_price) }}</option>
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
    <table class="table table-bordered" id="planner-package-others-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>SERVICE</th>
                <th>SERVICE FEE</th>
                <th>ACTION</th>
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
                        // {
                        //     "extend": 'csv',
                        //     'title' :`EVENT-${event_name}-OTHER-SERVICE-LISTS`,
                        //     "exportOptions": {
                        //         "columns": [0,1]
                        //     }
                        // },
                        // {
                        //     "extend": 'pdf',
                        //     'title' :`EVENT-${event_name}-OTHER-SERVICE-LISTS`,
                        //     "exportOptions": {
                        //         "columns": [0,1]
                        //     }
                        // },
                        {
                            "extend": 'print',
                            'title' :``,
                            "exportOptions": {
                                "columns": [0,1]
                            },
                            "customize": function ( win ) {
                                $(win.document.body)
                                    .css( 'font-size', '10pt' )
                                    .prepend(
                                        `
                                        <div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
                                            <div class="title-header">
                                                <h2>EVENT-${event_name}-OTHER-SERVICE-LISTS</h2>
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
                { data: "name" },
                { data: "service_price" },
                { data: "action", searchable: false, orderable: false },
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