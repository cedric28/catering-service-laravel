<!--- Add Task Modal -->
<div id="editPlannerEquipmentModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="plannerEquipmentData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="plannerEquipmentTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closePlannerEquipmentModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="planner_equipment_id" name="planner_equipment_id" value="">
                    <div class="form-group row">
                        <h5 align="center" class="w-100"><span class="text-danger" id="planner_equipment_status_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Status:</label>
                        <div class="col-lg-9">
                            <select id="planner_equipment_status" name="planner_equipment_status" class="@error('planner_equipment_status') is-invalid @enderror form-control select2">
                                <option value="">Select Status</option>
                                @foreach ($equipmentStatus as $stat)
                                    <option value="{{ $stat['status'] }}">{{ ucwords($stat['status']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="hide-show-return-quantity">
                        <h5 align="center" class="w-100"><span class="text-danger" id="planner_return_quantity_error"></span></h5>
                        <label class="col-lg-3 col-form-label">Returned Quantity:</label>
                        <div class="col-lg-9">
                        <input id="planner_returned_quantity" type="number" name="planner_returned_quantity" value="{{ old('planner_returned_quantity') }}" class="@error('planner_returned_quantity') is-invalid @enderror form-control" placeholder="e.g 100">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="update_planner_equipment_button" id="update_planner_equipment_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closePlannerEquipmentModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    let selectedStat = $("#planner_equipment_status option:selected" ).val();
    if(selectedStat != 'returned'){
        $('#hide-show-return-quantity').hide();
    } else {
        $('#hide-show-return-quantity').show();
    }
    $(document).on('change', '#planner_equipment_status', function(event){
        event.preventDefault();
        let selectedStatus = $(this).find(":selected").val();
        if(selectedStatus != 'returned'){
            $('#hide-show-return-quantity').hide();
        } else {
            $('#hide-show-return-quantity').show();
        }
    });

    $(document).on('click', '#edit-planner-equipment', function(event){
        event.preventDefault();
        $('#plannerEquipmentTitle').html(`Update Equipment Detail`);
        let plannerEquipmentId = $(this).attr('data-id');
        let plannerEquipmentStatus = $(this).attr('data-planner-equipment-status');
        if(plannerEquipmentStatus != 'returned'){
            $('#hide-show-return-quantity').hide();
        } else {
            $('#hide-show-return-quantity').show();
        }
        let plannerReturnedQuantity = $(this).attr('data-return-qty');
        $('#planner_equipment_id').val(plannerEquipmentId);
        $('#planner_returned_quantity').val(plannerReturnedQuantity);
        $(`select[name^="planner_equipment_status"] option[value=${plannerEquipmentStatus}]`).attr("selected","selected");
        $('#editPlannerEquipmentModal').modal('show');
    });

    function closePlannerEquipmentModal() {
        $("#plannerEquipmentData").trigger("reset");
        $('#update_planner_equipment_button').text('OK');
        $("#plannerEquipmentData input:hidden").val("");
    
        $("#planner_equipment_status").removeClass("is-invalid");
        $("#planner_returned_quantity").removeClass("is-invalid");

        $('#planner_equipment_status_error').text("");
        $('#planner_return_quantity_error').text("");
        $(`select[name^="planner_equipment_status"] option:selected`).removeAttr("selected");
    }

    $(document).on('click','#update_planner_equipment_button',function(event){
        event.preventDefault();
        let planner_equipments_ids = $("#planner_equipment_id").val();
        let planner_equipment_status = $("#planner_equipment_status option:selected" ).val();
        let planner_returned_quantity = $("#planner_returned_quantity").val();
        console.log({
            planner_equipments_ids,
            planner_equipment_status,
            planner_returned_quantity
        });
        $.ajax({
            url:"<?= route('updateEquipment') ?>",
            dataType:"json",
            type:"POST",
            data:{
                "_token":"<?= csrf_token() ?>",
                "planner_equipments_id": planner_equipments_ids,
                "status": planner_equipment_status,
                "return_qty": planner_returned_quantity
            },
            beforeSend:function(){
                $('#update_planner_equipment_button').text('Saving...');
            },
            success:function(data)
            {
                $("#plannerEquipmentData").trigger("reset");
                $('#editPlannerTaskModal').modal('hide');
                $("#plannerEquipmentData").trigger("reset");
                $('#update_planner_equipment_button').text('OK');
                $("#plannerEquipmentData input:hidden").val("");
                $("#planner_equipment_status").removeClass("is-invalid");
                $("#planner_returned_quantity").removeClass("is-invalid");
                tablePlannerEquipment.ajax.reload();
                $('#planner_equipment_status_error').text("");
                $('#planner_return_quantity_error').text("");
                $(`select[name^="planner_equipment_status"] option:selected`).removeAttr("selected");
                $('#editPlannerEquipmentModal').modal('hide');
            },
            error:function(err){
                if(err.responseJSON){
                    let receivedMessage = err.responseJSON.data;
                    if(receivedMessage.status){
                        $('#planner_equipment_status_error').text(receivedMessage.status[0]);
                        $("#planner_equipment_status").addClass("is-invalid");
                    } else {
                        $('#planner_equipment_status_error').text("");
                        $("#planner_equipment_status").removeClass("is-invalid");
                    }

                    if(receivedMessage.return_qty){
                        $('#planner_return_quantity_error').text(receivedMessage.return_qty[0]);
                        $("#planner_returned_quantity").addClass("is-invalid");
                    }else {
                        $('#planner_return_quantity_error').text("");
                        $("#planner_returned_quantity").removeClass("is-invalid");
                    }

                    $('#update_planner_equipment_button').text('Save');
                }
            }
        })
    });
</script>
@endpush('scripts')