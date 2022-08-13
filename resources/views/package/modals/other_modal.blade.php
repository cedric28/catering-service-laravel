<!--- Add Other Modal -->
<div id="addOtherModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="otherData">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100"><span id="otherTitle"></span></h4>
                    <button type="button" class="close float-right" onclick="closeOtherModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalOtherError"></span></h5>
                    <input type="hidden" id="other_id" name="other_id" value="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Name:</label>
                        <div class="col-lg-9 col-sm-9">	
                            <input type="text" id="other-name" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="e.g Another Digital Photography" >
                        </div>
                    </div>
                    <h5 align="center" class="w-100"><span class="text-danger" id="generalPriceError"></span></h5>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Price:</label>
                        <div class="col-lg-9 col-sm-9">	
                            <input type="text" id="service_price" name="service_price" class="@error('service_price') is-invalid @enderror form-control" placeholder="e.g 100" >
                        </div>
                    </div>				
                </div>
                <div class="modal-footer">
                <button type="button" name="add_other_button" id="add_other_button" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-default" onclick="closeOtherModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    //add other
        var tableOther = $('#package-others-lists').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"<?= route('activePackageOther') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{
                    "_token":"<?= csrf_token() ?>",
                    "package_id": packageId
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
                            'title' :`PACKAGE-${packageName}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'pdf',
                            'title' :`PACKAGE-${packageName}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        },
                        {
                            "extend": 'print',
                            'title' :`PACKAGE-${packageName}-OTHER-SERVICE-LISTS`,
                            "exportOptions": {
                                "columns": [0,1,2]
                            }
                        }
                    ],
                }
            ],
            "columns":[
                {"data":"name"},
                {"data":"service_price"},
                {"data":"created_at"},
                {"data":"action","searchable":false,"orderable":false}
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

        function closeOtherModal() {
            $("#otherData").trigger("reset");
            $("#otherData input:hidden").val("");
            $("#other-name").removeClass("is-invalid");
            $('#generalOtherError').text("");
            $('#generalPriceError').text("");
            $("#service_price").removeClass("is-invalid");
        }

        $(document).on('click', '#add-other', function(event){
            event.preventDefault();
            $('#otherTitle').html("Add New Service");
            $('#addOtherModal').modal('show');
        });

        $(document).on('click', '#edit-other-package', function(event){
            event.preventDefault();
            $('#otherTitle').html("Update Additional Service Detail");
            let otherId = $(this).attr('data-id');
            let other_name = $(this).attr('data-name');
            let other_service_fee = $(this).attr('data-price');
            console.log(otherId);
            $('#other_id').val(otherId);
            $('#other-name').val(other_name);
            $('#service_price').val(other_service_fee);
            $('#addOtherModal').modal('show');
        });

        $('#add_other_button').click(function(event){
            event.preventDefault();
            let other_id = $( "#other_id").val();
            let other_name = $("#other-name").val();
            let service_price = $("#service_price").val();
            console.log({
                other_id,
                other_name,
                service_price
            })
            $.ajax({
                url:"<?= route('addOther') ?>",
                dataType:"json",
                type:"POST",
                data:{
                    "_token":"<?= csrf_token() ?>",
                    "other_id": other_id,
                    "package_id": packageId,
                    "name": other_name,
                    "service_price" : service_price
                },
                beforeSend:function(){
                    $('#add_other_button').text('Saving...');
                },
                success:function(data)
                {
                    $("#otherData").trigger("reset");
                    $('#addOtherModal').modal('hide');
                    tableOther.ajax.reload();
                    $('#add_other_button').text('OK');
                    $("#other-name").removeClass("is-invalid");
                    $("#service_price").removeClass("is-invalid");
                    $('#generalOtherError').text("");
                    $('#generalPriceError').text("");
                    $("#otherData input:hidden").val("");   
                },
                error:function(err){
                    if(err.responseJSON){
                        let receivedMessage = err.responseJSON.data;
                        if(receivedMessage.name){
                            $('#generalOtherError').text(receivedMessage.name[0]);
                            $("#other-name").addClass("is-invalid");
                        } else {
                            $('#generalOtherError').text("");
                            $("#other-name").removeClass("is-invalid");
                        }
                        if(receivedMessage.service_price){
                            $('#generalPriceError').text(receivedMessage.service_price[0]);
                            $("#service_price").addClass("is-invalid");
                        } else {
                            $("#service_price").removeClass("is-invalid");
                            $('#generalPriceError').text("");
                        }
                        
                        $('#add_other_button').text('Save');
                    }
                }
            })
        });
    </script>
@endpush('scripts')