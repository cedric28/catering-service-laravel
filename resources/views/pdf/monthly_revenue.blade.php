<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>MONTHLY-REVENUE-REPORT</title>

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
									<h4 class="title">MONTHLY REVENUE REPORT</h5>
                                    <!-- <div class="title2">CREATIVE MOMENTS CATERING SERVICES</div>
                                    <div class="title2">2nd floor, Miranda Plaza Building</div>
                                    <div class="title2">Binan City, Laguna</div>
                                    <div class="title2">creativemomentscatering@yahoo.com</div>
									<div class="title2">DATE ISSUED: {{ $formattedDate }}</div>
                                    <div class="title2">DATE RANGE: {{ $startDate }} - {{ $endDate }}</div>
									<div class="title2">PREPARED BY: {{ ucwords(Auth::user()->name) }}</div> -->
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
                                <th>DATE ISSUED: {{ $formattedDate }}</th>
								<th>CREATIVE MOMENTS CATERING SERVICES</th>
							</tr>
                            <tr>
                                <th>DATE RANGE: {{ $startDate }} - {{ $endDate }}</th>
								<th>2nd floor, Miranda Plaza Building</th>
							</tr>
							<tr>
                                <th>PREPARED BY: {{ ucwords(Auth::user()->name) }}</th>
								<th>Binan City, Laguna</th>
							</tr>
							<tr>
                                <th></th>
								<th>creativemomentscatering@yahoo.com</th>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>INVOICE NO</td>
					<td>PAYMENT</td>
				</tr>

				@foreach($sales as $sale)
					<tr class="item">
						<td >{{$sale->planner->or_no}}</td>
						<td>{{ Str::currency($sale->payment_price) }}</td>
					</tr>
                @endforeach
			

				<tr class="total">
					<td></td>
					<td>Total: {{ Str::currency($totalPrice) }}</td>
				</tr>
			</table>
            <footer>
                <div id="legalcopy" class="clearfix">
                    {{-- <p class="col-right">Copyright © CREATIVE MOMENTS CATERING SERVICES 2022
                    </p> --}}
                </div>
            </footer>
		</div>
	</body>
</html>