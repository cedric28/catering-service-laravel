<!--- Add Task Modal -->
<div id="seeCustomerDetailsModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog" style="max-width: 50%;" role="document">
        <form id="plannerSeeDetails">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100">Customer History Details</h4>
                    <button type="button" class="close float-right" onclick="closeCustomerDetailsModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Customer First name</th>
                                            <th id="customer_firstname"></th>
                                        </tr>
                                        <tr>
                                            <th>Customer Last name</th>
                                            <th id="customer_lastname"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="customer-history-lists"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>EVENT NAME</th>
                                            <th>EVENT DATE & TIME</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="closeCustomerDetailsModal()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
    let tableCustomerHistoryList = "";
    $(document).on('click', '#see-customer-details', function(event){
        event.preventDefault();
        if(customerId !== ''){
            $('#seeCustomerDetailsModal').modal('show');
            $('#customer_id').removeClass("is-invalid");
            tableCustomerHistoryList = $('#customer-history-lists').DataTable({
                "responsive": true, 
                "lengthChange": false, 
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url":"<?= route('customerHistory') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{
                        "_token":"<?= csrf_token() ?>",
                        "customer_id": customerId,
                    }
                },
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        "extend": 'collection',
                        "text": 'Export',
                        "buttons": [
                        
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
                                                    <h2>CUSTOMER-EVENT-HISTORY-LISTS</h2>
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
                "columns": [ 
                    {"data":"event_name"},
                    {"data":"event_date_and_time"}
                ],
                "columnDefs": [
                    {
                        "targets": [],   // target column
                        "className": "textCenter",
                    }
                ]
            });
        } else {
            $('#customer_id').addClass("is-invalid");
        }
    });

    function closeCustomerDetailsModal() {
        tableCustomerHistoryList.destroy();
    }
</script>

@endpush('scripts')
