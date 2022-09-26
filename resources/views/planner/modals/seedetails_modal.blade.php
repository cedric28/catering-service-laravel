<!--- Add Task Modal -->
<div id="seeDetailsPlannerModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog">
        <form id="plannerSeeDetails">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100">Package Details</h4>
                    <button type="button" class="close float-right" onclick="closePlannerDetailsModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  
                    <div class="form-group row">
                       
                    </div>
                    <div class="form-group row">
                        
                    </div>

                    <div class="form-group row">
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="closePlannerDetailsModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '#see-details', function(event){
        event.preventDefault();
        console.log("PackageId", packageId);
        $('#seeDetailsPlannerModal').modal('show');
    });
</script>

@endpush('scripts')