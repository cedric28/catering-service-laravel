<!--- Add Equipment Modal -->
<div id="addEquipmentModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="equipmentData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="equipmentTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closeEquipmentModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalEquipmentError"></span></h5>
                    <input type="hidden" id="equipment_id" name="equipment_id" value="">
                    <div class="form-group row" id="select-equipment">
                        <label class="col-lg-3 col-form-label">Equipments:</label>
                        <div class="col-lg-9">
                            <select id="inventory_id" name="inventory_id" class="@error('inventory_id') is-invalid @enderror form-control select2">
                                <option value="">Select Equipment</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ ucwords($inventory->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalQuantityError"></span></h5>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Quantity:</label>
                        <div class="col-lg-9 col-sm-9">	
                            <input type="text" id="equipment-quantity" name="quantity" class="@error('quantity') is-invalid @enderror form-control" placeholder="e.g 100" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" name="add_equipment_button" id="add_equipment_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closeEquipmentModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
        //add equipment
      
        const columnsEquipment = isShow == 0 ? [ 
                {"data":"name"},
                {"data":"quantity"},
                {"data":"created_at"},
                {"data":"action","searchable":false,"orderable":false}
        ] :  [ 
                {"data":"name"},
                {"data":"quantity"},
                {"data":"created_at"}
        ];
        var tableEquipments = $('#package-equipments-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePackageEquipment') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{
                    "_token":"<?= csrf_token() ?>",
                    "package_id": packageId,
                    "is_show" : isShow
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
                            'title' :`PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        }
                    ],
                }
            ],
            "columns": columnsEquipment,
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

        var package_equipment_id;
        $(document).on('click', '#delete-equipment-package', function(){
            package_equipment_id = $(this).attr('data-id');
            $('#confirmEquipmentModal').modal('show');
        });

        $('#ok_equipment_button').click(function(){
            $.ajax({
                url:"/packages-equipment/destroy/"+package_equipment_id,
                beforeSend:function(){
                    $('#ok_equipment_button').text('Deleting...');
                },
                success:function(data)
                {
                    $('#confirmEquipmentModal').modal('hide');
                    $('#ok_equipment_button').text('OK');
                    tableEquipments.ajax.reload();
                    tableInactiveEquipments.ajax.reload();
                }
            })
        });

        function closeEquipmentModal() {
                $('#ok_equipment_button').text('OK');
                $("#equipmentData").trigger("reset");
                $("#equipmentData input:hidden").val("");
                $("#equipment-quantity").removeClass("is-invalid");
                $('#generalEquipmentError').text("");
                $('#generalQuantityError').text("");
                $("#equipment-quantity").removeClass("is-invalid");
                $(`select[name^="inventory_id"] option:selected`).removeAttr("selected");
           
        }

        $(document).on('click', '#add-equipment', function(event){
            event.preventDefault();
            $('#equipmentTitle').html("Add New Equipment");
            $('#select-equipment').show();
            $('#addEquipmentModal').modal('show');
        });

        $(document).on('click', '#edit-equipment-package', function(event){
            event.preventDefault();
            $('#equipmentTitle').html("Update Equipment Detail");
            let equipmentId = $(this).attr('data-id');
            let quantity = $(this).attr('data-quantity');
            let inventoryId = $(this).attr('data-inventory-id');
            console.log(inventoryId);
            // $('#select-equipment').hide();
            $('#equipment_id').val(equipmentId);
            $('#equipment-quantity').val(quantity);
            $(`select[name^="inventory_id"] option[value=${inventoryId}]`).attr("selected","selected");
            $('#addEquipmentModal').modal('show');
        });

        $('#add_equipment_button').click(function(event){
            event.preventDefault();
            let inventory_id = $( "#inventory_id option:selected").val();
            let equipment_id = $("#equipment_id").val();
            let quantity = $("#equipment-quantity").val();
            console.log({
                inventory_id,
                equipment_id,
                quantity
            })
            $.ajax({
                url:"<?= route('addEquipment') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "inventory_id": inventory_id,
                    "package_id": packageId,
                    "equipment_id": equipment_id ? equipment_id : 0,
                    "quantity" : quantity
                },
                beforeSend:function(){
                    $('#add_equipment_button').text('Saving...');
                },
                success:function(data)
                {
                    $("#equipmentData").trigger("reset");
                    $('#addEquipmentModal').modal('hide');
                    tableEquipments.ajax.reload();
                    $('#add_equipment_button').text('OK');
                    $("#inventory_id").removeClass("is-invalid");
                    $("#equipment-quantity").removeClass("is-invalid");
                    $('#generalEquipmentError').text("");
                    $('#generalQuantityError').text("");
                    $("#equipmentData input:hidden").val("");
                    $(`select[name^="inventory_id"] option:selected`).removeAttr("selected");
                    
                },
                error:function(err){
                    if(err.responseJSON){
                        let receivedMessage = err.responseJSON.data;
                        if(receivedMessage.inventory_id){
                            $('#generalEquipmentError').text(receivedMessage.inventory_id[0]);
                            $("#inventory_id").addClass("is-invalid");
                        }else{
                            $('#generalEquipmentError').text("");
                            $("#inventory_id").removeClass("is-invalid");
                        }
                        if(receivedMessage.quantity){
                            $('#generalQuantityError').text(receivedMessage.quantity[0]);
                            $("#equipment-quantity").addClass("is-invalid");
                        }else{
                            $('#generalQuantityError').text("");
                            $("#equipment-quantity").removeClass("is-invalid");
                        }
                        
                        $('#add_equipment_button').text('Save');
                    }
                }
            })
        });


        var tableInactiveEquipments = $('#inactive-package-equipments-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('InactivePackageEquipment') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{
                    "_token":"<?= csrf_token() ?>",
                    "package_id": packageId,
                    "is_show" : isShow
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
                            'title' :`ARCHIVED-PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`ARCHIVED-PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`ARCHIVED-PACKAGE-${packageName}-EQUIPMENTS-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        }
                    ],
                }
            ],
            "columns": columnsEquipment,
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

        $(document).on('click', '#restore-package-equipment', function(){
            const packageEquipmentId = $(this).attr('data-id');
            $.ajax({
                url:"/packages-equipment/restore/"+packageEquipmentId,
                success:function(data)
                {
                    tableInactiveEquipments.ajax.reload();
                    tableEquipments.ajax.reload();
                }
            })
        });
    </script>
@endpush('scripts')