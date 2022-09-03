@if($planner->status != 'done')
<form action="{{ route('storeEquipment')}}" method="POST" class="mb-2">
    @csrf
    <input type="hidden" name="planner_id" value="{{ $planner->id }}"/>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">Equipment:</label>
        <div class="col-lg-9">
            <select id="package_equipment_id" name="package_equipment_id" class="@error('package_equipment_id') is-invalid @enderror form-control select2">
                <option value="">Select Equipment</option>
                @foreach ($package_equipments as $package_equipment)
                    <option value="{{ $package_equipment->id }}" {{ ($package_equipment->id == old("package_equipment_id")) ? " selected" : "" }}>{{ ucwords($package_equipment->package_equipment->name) }}</option>
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
    <table class="table table-bordered" id="planner-equipments-lists"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>EQUIPMENT NAME</th>
                <th>REQUIRED QUANTITY</th>
                <th>CURRENT QUANTITY</th>
                <th>RETURNED QUANTITY</th>
                <th>REMARKS</th>
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
                            'title' :`EVENT-${event_name}-EQUIPMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`EVENT-${event_name}-EQUIPMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`EVENT-${event_name}-EQUIPMENT-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2,3]
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
                { data: "action", searchable: false, orderable: false },
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
@include('planner.modals.equipment_modal')
@endpush('scripts')