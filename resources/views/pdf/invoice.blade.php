<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>INVOICE-{{ $planner->or_no }}-{{ strtoupper($planner->event_name) }}</title>

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
				padding-bottom: 2px;
                text-align: left;
                width: 50%;
                font-size: 15px;
			}

			.invoice-box table tr.information table th.address {
				font-style: normal !important;  
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
									<h4 class="title">INVOICE</h5>
									<div class="title2">INVOICE NUMBER: {{ $planner->or_no }}</div>
									<div class="title2">DATE ISSUED: {{ $formattedDate }}</div>
									<div class="title2">PREPARED BY: {{ ucwords(Auth::user()->name) }}</div>
								</td>
								<td class="title">
									<img src="assets/img/logo-pink.png" style="width: 100%; max-width: 100px;height: 100px;" />
								</td>

							
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
                                <th>BILLED TO: {{ ucwords($planner->customer->customer_firstname) }} {{ ucwords($planner->customer->customer_lastname) }}</th>
								<th>CREATIVE MOMENTS CATERING SERVICES</th>
							</tr>
                            <tr>
                                <th>+63{{ ($planner->customer->contact_number) }}</th>
								<th class="address">2nd floor, Miranda Plaza Building</th>
							</tr>
							<tr>
                                <th></th>
								<th class="address">Binan City, Laguna</th>
							</tr>
							<tr>
                                <th></th>
								<th>creativemomentscatering@yahoo.com</th>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>DESCRIPTION</td>
					<td>AMOUNT</td>
				</tr>

				<tr class="item">
					<td>{{ ucwords($planner->package->name)}}</td>
					<td>{{ Str::currency($planner->package->package_price) }}</td>
				</tr>
				@foreach($plannerOther as $other)
					<tr class="item">
						<td>{{ $other->package_other->name }}</td>
						<td>{{ Str::currency($other->package_other->service_price) }}</td>
					</tr>
                @endforeach
				

				<!-- <tr class="item last">
					<td>Domain name (1 year)</td>

					<td>$10.00</td>
					<td>$75.00</td>
				</tr> -->

				<tr class="total">
					<td></td>
					<td>Total: {{ Str::currency($totalBalance) }}</td>
				</tr>
			</table>
			<footer>
                <div id="legalcopy" class="clearfix">
                    <p class="col-right">Copyright © CREATIVE MOMENTS CATERING SERVICES 2022
                    </p>
                </div>
            </footer>
		</div>
	</body>
</html>