<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>CONTRACT-{{ $planner->or_no }}-{{ strtoupper($planner->event_name) }}</title>

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
				/* border: 1px solid #eee; */
				/* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
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

			.invoice-box table tr.information table th {
				padding-bottom: 5px;
                text-align: left;
                width: 50%;
                font-size: 15px;
			}

            .invoice-box table tr.information table  {
				border: 5px solid black;
                padding: 20px;
			}

            .invoice-box table tr.signed td h2:nth-child(1){
                padding-top: 60px;
                padding-bottom: 60px;
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

				.invoice-box table tr.information table th {
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
                font-size: 30px;
            }
            .title2{
                font-size: 20px;
            }

            .description{
                text-align: justify;
                width: 100%;
            }
            .prepared-by{
                text-decoration: overline;
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
									<h4 class="title">CATERING CONTRACT</h4>
									<h4 class="title">Prepared By: {{ ucwords(Auth::user()->name) }}</h4>
								</td>

                                <td class="title">
									<img src="assets/img/logo-pink.png" style="width: 100%; max-width: 100px;height: 100px;" />
								</td>

							</tr>
						</table>
					</td>
				</tr>
                <tr>
                    <td>
                        <p class="description">This Catering Contract is entered into between the Creating Moments Catering Services and <strong>{{ ucwords($planner->customer_fullname) }}</strong>, sets forth the agreement between the Parties relating to catering services to be provided by the Caterer for Client for the event identified in this Contract.</p>
                    </td>
                </tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
                                <th>Event Name: {{ ucwords($planner->event_name) }}</th>
								<th>Client Name: {{ ucwords($planner->customer_fullname) }}</th>
							</tr>
                            <tr>
                                <th>Venue: {{ ucwords($planner->event_venue) }}</th>
								<th>Contact: +63{{ ucwords($planner->contact_number) }}</th>
							</tr>
                            <tr>
                                <th>Date: {{ $formattedDate }}</th>
								<th>Payment Type:  
                                    @forelse($planner->payments as $payment)
                                    {{ $payment->payment_type }},
                                    @empty
                                    <p class="text-center">No Payment Made</p>
                                    @endforelse
                                </th>
							</tr>
                            <tr>
                                <th>Time: {{ $planner->event_time }}</th>
								<th>Package: {{ ucwords($planner->package->name) }}</th>
							</tr>
                            <tr>
                                <th>Event Type: {{ ucwords($planner->package->main_package->name) }}</th>
								<th>Expected no. of guests: {{ $planner->no_of_guests ?? 0 }} persons</th>
							</tr>
						</table>
					</td>
				</tr>

                <tr>
                    <td>
                        <h4 class="title2">MENU TO BE SERVED</h4>
                        <p class="description">The Parties have agreed to the menu attached to this Catering Agreement as Exhibit A. Caterer reserves the right to make small changes to the menu if key ingredients are unable to be sourced due to reasons beyond the control of the Parties. No alcoholic beverages will be served without a separate agreement relating thereto.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 class="title2">COORDINATION WITH VENUE</h4>
						@php
							$firstTime = "[Not yet set]";
							$lastTime = "[Not yet set]";
							
						@endphp
						@foreach ($timeTable as $time)
								@if($loop->first)
									@php $firstTime = $time->task_time; @endphp
								@endif

								@if($loop->last)
									@php $lastTime = $time->task_time; @endphp
								@endif
							
						@endforeach
						<p class="description">Caterer will need to have access to the Venue no later than {{ $firstTime }} hours in advance of the Start Time for the Event, and {{ $lastTime }}  hours after the End Time for cleanup. Client will make all necessary arrangements, at Client’s expense, to get this access arranged.</p>
                          
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">PAYMENT TERMS</h4>
                        <p class="description">In exchange for the services of Caterer as specified in this Catering Contract, Client will pay to the Caterer depending on the chosen payment type, 50% upfront payment or 100% full payment. The customer must pay one week before the Event the other 50% of the total price if the first chosen payment type is 50% prior to the package that was chosen. As of the signing of this Contract, the total amount is estimated to be {{ $servicePriceTotal }}.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">RESPONSIBILITIES FOR RELATED COSTS</h4>
                        <p class="description">Client is solely responsible for all costs and/or deposits relating to use of the Venue, and for obtaining any necessary permissions, authorizations, or other requirement of Caterer providing services at the Venue.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">INSURANCE AND INDEMNIFICATION</h4>
                        <p class="description">Caterer has, or will obtain, general liability insurance relating to Caterer’s services at the Event. However, Client will indemnify and hold harmless Caterer for any damage, theft, or loss of Caterer’s property occurring at the event, causes by any of Client’s guests.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">LEGAL COMPLIANCE</h4>
                        <p class="description">Caterer will work in compliance with all applicable local health department rules and regulations relating to food preparation and food service.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">ASSIGNMENT</h4>
                        <p class="description">This Contract cannot be assigned by either Party without the other’s written consent, with the exception set forth in paragraph 10, below.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">LIMITATION OF REMEDIES</h4>
                        <p class="description">If Caterer cannot fulfill its obligations under this Contract for reasons outside of its control, Caterer may locate and retain a replacement catering company at no additional cost to Client, or refund Client’s money in full. Caterer will not be responsible for any additional damages or compensation under these circumstances.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">RESOLUTION OF DISPUTES</h4>
                        <p class="description">The Parties agree to not post any negative information about the other arising out of this Contract or Event on any online forum or website without providing advance written notice of the intended content thereof, and providing the other party with an opportunity to resolve any issues between the parties amicably.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h4 class="title2">ENTIRE AGREEMENT</h4>
                        <p class="description">This document, along with its exhibits and attachments, constitutes the entire agreement between the Parties. <strong>Creative Moments Catering Services</strong> and <strong>{{ ucwords($planner->customer_fullname) }}</strong></p>
                    </td>
                </tr>

                <tr class="signed">
					<td>
						<h4 class="prepared-by">Prepared By: {{ ucwords(Auth::user()->name) }}</h4>
                        <h4 class="prepared-by">Client Name: {{ ucwords($planner->customer_fullname) }}</h4>
					</td>
				</tr>

				<!-- <tr class="heading">
					<td>Payment Method</td>

					<td>Check #</td>
				</tr>

				<tr class="details">
					<td>Check</td>

					<td>1000</td>
				</tr>

				<tr class="heading">
					<td>Item</td>

					<td>Price</td>
				</tr>

				<tr class="item">
					<td>Website design</td>

					<td>$300.00</td>
				</tr>

				<tr class="item">
					<td>Hosting (3 months)</td>

					<td>$75.00</td>
				</tr>

				<tr class="item last">
					<td>Domain name (1 year)</td>

					<td>$10.00</td>
				</tr>

				<tr class="total">
					<td></td>

					<td>Total: $385.00</td>
				</tr> -->
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