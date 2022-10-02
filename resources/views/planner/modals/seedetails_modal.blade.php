<!--- Add Task Modal -->
<div id="seeDetailsPlannerModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog" style="max-width: 50%;" role="document">
        <form id="plannerSeeDetails">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 align="center" class="w-100">Package Details</h4>
                    <button type="button" class="close float-right" onclick="closePlannerDetailsModal()" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th id="see_package_name"></th>
                                        </tr>
                                        <tr>
                                            <th>Package Pax</th>
                                            <th id="see_package_pax"></th>
                                        </tr>
                                        <tr>
                                            <th>Package Price</th>
                                            <th id="see_package_price"></th>
                                        </tr>
                                        <tr>
                                            <th>Package Category</th>
                                            <th id="see_package_category"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow card-primary card-outline card-outline-tabs border-top-primary mt-3">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Tasks</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Equipments</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Food Menu</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Other</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="package-tasks-lists"  width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>TASK NAME</th>
                                                            <th>DATE ADDED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="package-equipments-lists"  width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>EQUIPMENT NAME</th>
                                                            <th>QUANTITY</th>
                                                            <th>DATE ADDED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="package-foods-lists"  width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>FOOD CATEGORY</th>
                                                            <th>DATE ADDED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="package-others-lists"  width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>NAME</th>
                                                            <th>SERVICE FEE</th>
                                                            <th>DATE ADDED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
					        </div>
                        </div>
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
   
    let logo = window.location.origin + '/assets/img/logo-pink.png';
    let user_login = {!! json_encode( ucwords(Auth::user()->name)) !!};
    let dateToday = new Date();
    let tableTasksList = "";
    let tableOther = "";
    let tableFood = "";
    let tableEquipments = "";
    $(document).on('click', '#see-details', function(event){
        event.preventDefault();
        console.log("PackageId", packageId);
        if(packageId !== ''){
            $('#seeDetailsPlannerModal').modal('show');
            $('#package_id').removeClass("is-invalid");
            $.ajax({
                url: "/packages-show/"+packageId,
                success:function(data)
                {
                    const { package, package_main } = data;
                    $('#see_package_name').html(package.name);
                    $('#see_package_pax').html(package.package_pax);
                    $('#see_package_price').html("P" +package.package_price);
                    $('#see_package_category').html(package_main);
                    packageName = package.name;


                    tableTasksList = $('#package-tasks-lists').DataTable({
                        "responsive": true, 
                        "lengthChange": false, 
                        "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url":"<?= route('activePackageTask') ?>",
                            "dataType":"json",
                            "type":"POST",
                            "data":{
                                "_token":"<?= csrf_token() ?>",
                                "package_id": packageId,
                                "is_show" : 1
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
                                                            <h2>PACKAGE-${packageName}-TASK-LISTS</h2>
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
                            {"data":"name"},
                            {"data":"created_at"}
                        ],
                        "columnDefs": [
                            {
                                "targets": [1],   // target column
                                "className": "textCenter",
                            }
                        ]
                    });


                    tableOther = $('#package-others-lists').DataTable({
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
                                "package_id": packageId,
                                "is_show" : 1
                            }
                        },
                        "dom": 'Bfrtip',
                        "buttons": [
                            {
                                "extend": 'collection',
                                "text": 'Export',
                                "buttons": [
                                    {
                                        "extend": 'print',
                                        'title' : ``,
                                        "exportOptions": {
                                            "columns": [0,1,2]
                                        },
                                        "customize": function ( win ) {
                                            $(win.document.body)
                                                .css( 'font-size', '10pt' )
                                                .prepend(
                                                    `
                                                    <div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
                                                        <div class="title-header">
                                                            <h2>PACKAGE-${packageName}-OTHER-SERVICE-LISTS</h2>
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
                            {"data":"name"},
                            {"data":"service_price"},
                            {"data":"created_at"},
                        ],
                        "columnDefs": [
                            {
                                "targets": [2],   // target column
                                "className": "textCenter",
                            },
                            {
                                "targets": [1],   // target column
                                "className": "textRight",
                            }
                        ]
                    });


                    tableFood = $('#package-foods-lists').DataTable({
                        "responsive": true, 
                        "lengthChange": false, 
                        "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url":"<?= route('activePackageFood') ?>",
                            "dataType":"json",
                            "type":"POST",
                            "data":{
                                "_token":"<?= csrf_token() ?>",
                                "package_id": packageId,
                                "is_show" : 1
                            }
                        },
                        "dom": 'Bfrtip',
                        "buttons": [
                            {
                                "extend": 'collection',
                                "text": 'Export',
                                "buttons": [
                                    {
                                        "extend": 'print',
                                        'title' : ``,
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
                                                            <h2>PACKAGE-${packageName}-FOOD-MENU</h2>
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
                            {"data":"name"},
                            {"data":"created_at"}
                        ],
                        "columnDefs": [
                        {
                            "targets": [1],   // target column
                            "className": "textCenter",
                        }
                        ]
                    });


                    tableEquipments = $('#package-equipments-lists').DataTable({
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
                                "is_show" : 1
                            }
                        },
                        "dom": 'Bfrtip',
                        "buttons": [
                            {
                                "extend": 'collection',
                                "text": 'Export',
                                "buttons": [
                                    {
                                        "extend": 'print',
                                        'title' : ``,
                                        "exportOptions": {
                                            "columns": [0,1,2]
                                        },
                                        "customize": function ( win ) {
                                            $(win.document.body)
                                                .css( 'font-size', '10pt' )
                                                .prepend(
                                                    `
                                                    <div style="display:flex;justify-content: space-between;margin-bottom: 20px;">
                                                        <div class="title-header">
                                                            <h2>PACKAGE-${packageName}-EQUIPMENTS-LISTS</h2>
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
                                {"data":"name"},
                                {"data":"quantity"},
                                {"data":"created_at"}
                        ],
                        "columnDefs": [
                            {
                                "targets": [2],   // target column
                                "className": "textCenter",
                            },
                            {
                                "targets": [1],   // target column
                                "className": "textRight",
                            }
                        ]
                    });
                },
                error: function(response)
                {
                    console.log("Error",response);
                }
            })
        } else {
            $('#package_id').addClass("is-invalid");
        }
    });

    function closePlannerDetailsModal() {
        $('#see_package_name').html("-");
        $('#see_package_pax').html("-");
        $('#see_package_price').html("-");
        $('#see_package_category').html("-");
        tableTasksList.destroy();
        tableOther.destroy();
        tableFood.destroy();
        tableEquipments.destroy();
    }
</script>

@endpush('scripts')
