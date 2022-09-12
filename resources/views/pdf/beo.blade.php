<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>BANQUET EVENT ORDER - {{ ucwords($planner->event_name) }}</title>
        <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet" type="text/css">
		<style>
			footer {
				border-top: 1px solid #eeeeee;;
				/* padding: 15px 20px; */
				padding: 50px 20% 0;
				text-align: center;
                font-size: 13px;
			}
			.invoice-box {
				max-width: 100%;
				margin: auto;
				padding: 30px;
				/* border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.information table th {
                text-align: left;
                width: 50%;
                font-size: 13px;
			}

			.invoice-box table tr.information table  {
				border: 5px solid black;
                padding: 20px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

			.title{
                font-size: 20px;
            }

			.title2{
                font-size: 15px;
				padding-bottom: 2px;
            }

            .column:nth-child(1) {
                float: left;
                width: 40%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            .column:nth-child(2) {
                float: left;
                width: 60%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            .column2:nth-child(1) {
                float: left;
                width: 33.33%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            .column2:nth-child(2) {
                float: left;
                width: 33.33%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            .column2:nth-child(3) {
                float: left;
                width: 33.33%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            /* Clear floats after the columns */
            .row:after {
            content: "";
            display: table;
            clear: both;
            }

            .textLeft {
			    text-align : left;
		    }
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
                				<td>
									<h4 class="title">BANQUET EVENT ORDER - {{ ucwords($planner->event_name) }}</h5>
								</td>
								<td class="title">
									<img src="{{ asset('assets/img/logo-pink.png') }}" style="width: 100%; max-width: 100px;height: 100px;" />
								</td>
							</tr>
						</table>
					</td>
                </tr>	
			</table>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr> 
                                <th>Event Name:</th>
                                <th>{{ ucwords($planner->event_name) }}</th>
                                <th>Client Name:</th>
                                <th>{{ ucwords($planner->customer_fullname) }}</th>
                            </tr>
                            <tr> 
                                <th>Venue:</th>
                                <th>{{ ucwords($planner->event_venue) }}</th>
                                <th>Contact No:</th>
                                <th>+63{{ $planner->contact_number }}</th>
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
                            <tr> 
                                <th>Prepared By:</th>
                                <th>{{ ucwords(Auth::user()->name) }}</th>
                                <th>Date Issued: </th>
                                <th>{{ $formattedDate }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="column">
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
                                    <td class="textLeft">{{ ucwords($time->task_name) }}</td>
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
                            @forelse($package_menus as $menu)
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
                <div class="column">
                    <h4 class="text-center">STAFFING </h4>
                    <div class="row">
                        <div class="column2">
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
                                                    <td class="text-center">{{ $staff->user->name }}</td>
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
                        <div class="column2">
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
                                                    <td class="text-center">{{ $staff->user->name }}</td>
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
                        <div class="column2">
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
                                                    <td class="text-center">{{ $staff->user->name }}</td>
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
	</body>
</html>