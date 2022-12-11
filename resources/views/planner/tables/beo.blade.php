<div class="text-center mb-2">
<a href="{{ route('printBEO', $planner->id)}}" class="btn btn-info ml-auto" id="printBEO">PRINT BEO</a>
</div>
<div class="card shadow">
    <div class="card-header">       
        <h5 class="card-title">BANQUET EVENT ORDER - {{ ucwords($planner->event_name) }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr> 
                            <th>Event Name:</th>
                            <th>{{ ucwords($planner->event_name) }}</th>
                            <th>Client Name:</th>
                            <th>{{ ucwords($planner->customer->customer_firstname) }} {{ ucwords($planner->customer->customer_lastname) }}</th>
                        </tr>
                        <tr> 
                            <th>Venue:</th>
                            <th>{{ ucwords($planner->event_venue) }}</th>
                            <th>Contact No:</th>
                            <th>+63{{ $planner->customer->contact_number }}</th>
                        </tr>
                        <tr> 
                            <th>Date:</th>
                            <th>{{ $planner->event_date }}</th>
                            <th>Payment Type:</th>
                            <th>
                                @forelse($planner->payments as $payment)
                                    {{ $payment->payment_type }},
                                @empty
                                <p class="text-center">No Payment Made</p>
                                @endforelse
                            </th>
                        </tr>
                        <tr> 
                            <th>Time:</th>
                            <th>{{ $planner->event_time }}</th>
                            <th>Package:</th>
                            <th>{{ $planner->package->name }}</th>
                        </tr>
                        <tr> 
                            <th>Event Type:</th>
                            <th>{{ $planner->package->main_package->name }}</th>
                            <th>Expected no. of guests:</th>
                            <th>{{ $planner->no_of_guests }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <h4 class="text-center">TIME TABLE</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> Time </th>
                                    <th> Task </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($planner->planner_time_tables as $time)
                                <tr> 
                                    <td>{{ $time->task_time }}</td>
                                    <td>{{ ucwords($time->task_name) }}</td>
                                </tr>
                                @empty
                                <tr> 
                                    <td colspan="2"><p class="text-center">No Data Available</p></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h4 class="text-center">MENU SELECTION </h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            @forelse($package_menus_beo as $menu)
                                <tr> 
                                    <td>{{ $menu->package_food_category->name }}</td>
                                    <td>
                                        @forelse($menu->package_food_category->foods as $menu)
                                            {{ ucwords($menu->name) }} ,
                                        @empty
                                            <p class="text-center">No Dish</p>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr> 
                                    <td colspan="2"><p class="text-center">No Data Available</p></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <h4 class="text-center">STAFFING </h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <center><b>SERVERS</b> <br></center>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Name</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                             
                                            @forelse($plannerStaffingsServer as $staff)  
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="">{{ $staff->user->name }}</td>
                                                </tr>
                                               
                                            @empty
                                                <tr> 
                                                    <td colspan="2"><p class="text-center">No Data Available</p></td>
                                                </tr>
                                            @endforelse
                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <center><b>BUSBOYS</b> <br></center>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>                 
                                            @forelse($plannerStaffingsBusboy as $staff)  
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="">{{ $staff->user->name }}</td>
                                                </tr>
                                               
                                            @empty
                                                <tr> 
                                                    <td colspan="2"><p class="text-center">No Data Available</p></td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <center><b>DISHWASHERS</b> <br></center>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">No</th>
                                                    <th scope="col" class="text-center">Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($plannerStaffingsDishwasher as $staff)  
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="">{{ $staff->user->name }}</td>
                                                </tr>
                                               
                                            @empty
                                                <tr> 
                                                    <td colspan="2"><p class="text-center">No Data Available</p></td>
                                                </tr>
                                            @endforelse
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
</div>

@push('scripts')
	<!-- Javascript -->
	<!-- Vendors -->
    <script src="{{ asset('assets/js/jquery.printPage.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#printBEO').printPage();
        });
    </script>

@endpush('scripts')