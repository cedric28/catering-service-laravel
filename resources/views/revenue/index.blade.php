@extends('layouts.app')

@section('content')
		<!-- Page Heading -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title d-flex">
					<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Monthly Revenue</span></h4>
					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>

			<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
				<div class="d-flex">
					<div class="breadcrumb">
						<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
						<a href="{{ route('revenueMonthly')}}" class="breadcrumb-item"> Monthly Revenue</a>
					</div>

					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>
		</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
            @include('partials.message')
			@include('partials.errors')
		</div>
		<div class="card-body">
            <div class="row col-md-12">
                <div class="col-md-7">
                    <a href="/generate-pdf-monthy-sales?start_date={{request('start_date')}}&end_date={{request('end_date')}}" class="btn btn-danger" id="generateMonthlySales">Generate PDF</a>
                    <a href="/print-monthly-sales?start_date={{request('start_date')}}&end_date={{request('end_date')}}" class="btn btn-primary" id="printMonthlySales">Print</a>
                </div>
                <div class="col-md-5">
                <form action="{{ route('revenueMonthly')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group date" id="start_date" data-target-input="nearest">
                                <input type="number" name="start_date" value="{{request('start_date')}}" class="@error('start_date') is-invalid @enderror form-control datetimepicker-input" data-target="#start_date"/>
                                <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <span class="ml-3 mt-2">to</span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group date" id="end_date" data-target-input="nearest">
                                <input type="number" name="end_date" value="{{request('end_date')}}" class="@error('end_date') is-invalid @enderror form-control datetimepicker-input" data-target="#end_date"/>
                                <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr style="text-align:center;">
                                <th>INVOICE NO</th>
                                <th>(₱) PAYMENT</th>
                                <th>DATE ADDED</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                <td class="textCenter">{{$sale->planner->or_no}}</td>
                                <td class="textRight">{{ Str::currency($sale->payment_price) }}</td>
                                <td class="textCenter">{{ date('Y-m-d', strtotime($sale->created_at)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $sales->render() }}
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
            $('#printMonthlySales').printPage();
        });
    </script>
	<script>
		$(function () {
			var d = new Date();
            var year = d.getFullYear() - 18;
            d.setFullYear(year);
        	//Date picker
			$('#start_date').datetimepicker({
                viewMode: 'months',
                format: 'MM',
                defaultDate: d
			});
            $('#end_date').datetimepicker({
                viewMode: 'months',
                format: 'MM',
                defaultDate: d,
                useCurrent: false 
			});

            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minYear(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxYear(e.date);
            });

        });
	</script>
	@endpush('scripts')
@endsection
