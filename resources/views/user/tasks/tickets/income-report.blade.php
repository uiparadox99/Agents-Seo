@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
    <!--   <h1>
       Manage Tickets
    </h1> -->
    <ol class="breadcrumb">
    	<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
    	<li class="active">Income Report</li>
    </ol>
 </section>
 <section class="content">
 	<div class="box">
 		<div class="box-header with-border">
 			<h2 class="text-center"><b>Income Report</b> {{request()->has('date_start') && !empty(request()->get('date_start'))?' | '.request()->get('date_start').' To '.request()->get('date_end'):''}}</h2>
 		</div>
 		<div class="box-body">
 			<div id="demo" class="collapse in" aria-expanded="true" >
 				<form class="form-validation" method="GET">
 					<div class="filters">
 						<div class="row">

 							<div class="col-md-3 form-group">
 								<div class="row tasks-dates">
 									<div class="col-md-6">
 										<label>Dates Between</label>
 										<input type="text" name="date_start" placeholder="From" autocomplete="off" class="form-control Searchdatepicker" value="{{request()->has('date_start')?request()->get('date_start'):''}}" data-validation="required"> 
 									</div>
 									<div class="col-md-6">
 										<label>&nbsp;</label>
 										<input type="text" name="date_end" autocomplete="off" placeholder="To" class="form-control Searchdatepicker" value="{{request()->has('date_end')?request()->get('date_end'):''}}">
 									</div>
 								</div>
 							</div>
						{{-- <div class="col-md-2 form-group">
							<label>Supplier</label>
							<select name="supplier" class="form-control validate[required]">
								<option value="">All</option>
								@foreach($suppliers as $s)
								<option value="{{ $s->id }}" {{request()->has('supplier') & request()->get('supplier') == $s->id?'selected':''}}>{{ $s->name }}</option>
								@endforeach
							</select>
						</div> --}}
						<div class="col-md-3 form-group">
							<label>Party</label>
							<select name="party" class="form-control validate[required] select2">
								<option value="">All</option>
								@foreach($parties as $p)
								<option value="{{ $p->id }}" {{request()->has('party') & request()->get('party') == $p->id?'selected':''}}>{{ $p->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2 form-group">
							<label>Staff</label>
							<select class="form-control" name="staff">
								<option value="">All</option>
								@foreach($admins_id as $a)
								<option value="{{ $a->id }}">{{ $a->name }}</option>
								@endforeach
							</select>
						</div>
						
						<div class="col-md-2 form-group">
							<label>Type</label>
							<select class="form-control" name="type">
								<option value="">Select</option>
								<option value="ticket" {{request()->has('type') & request()->get('type') == 'ticket'?'selected':''}}>Tickets</option>
								<option value="hotel_sales" {{request()->has('type') & request()->get('type') == 'hotel_sales'?'selected':''}}>Hotel Sales</option>
								<option value="tour_package" {{request()->has('type') & request()->get('type') == 'tour_package'?'selected':''}}>Tour Package</option>
								<option value="umrah_sales" {{request()->has('type') & request()->get('type') == 'umrah_sales'?'selected':''}}>Umrah Sales</option>
								<option value="travel_insurance" {{request()->has('type') & request()->get('type') == 'travel_insurance'?'selected':''}}>Travel Insurance</option>
								<option value="other_sales" {{request()->has('type') & request()->get('type') == 'other_sales'?'selected':''}}>Other Sales</option>
							</select>
						</div>
					
						<div class="col-md-1 form-group">
							<label>&nbsp;</label><br>
							<input type="submit" class="btn btn-success" value="Search">
						</div>

					</div>
				</div>
			</form>
		</div>
		{{-- <div class="filtered-params"> <h3>{{request()->has('date_start') && !empty(request()->get('date_start'))?' | '.request()->get('date_start').' To '.request()->get('date_end'):''}}</h3></div> --}}
		<table class="table table-bordered income-table">
			<thead>
				<tr>
					<th></th>
					<th>Passenger Name</th>
					<th>Sector</th>
					<th>Ticket Number</th>
					<th>PNR</th>
					<th>Party</th>
					<th>Staff</th>
					<th>Sale price</th>
					<th>Profit</th>
					<th>Receivable</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1;$total=0;$profit=0; @endphp
				@if(request()->has('date_start') && !empty(request()->get('date_start')))
				@foreach($tickets as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase"> {{ $t->given_name }} </td>
					<td>{{ $t->sector }}</td>
					<td>{{ $t->ticket_no }}</td>
					<td>{{ $t->airline_pnr }}</td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{!is_null($t->trans)?$t->trans->sale:''}}</td>
					<td>{{!is_null($t->trans)?$t->trans->profit:''}}</td>
					<td>{{!is_null($t->trans)?$t->trans->sale:''}}</td>
					<td>Ticket</td>
					@php
					if (!is_null($t->trans)) {
						$total = $total + $t->trans->sale;
					}
						if (!is_null($t->trans)) {
						$profit = $profit + $t->trans->profit;
					}

					@endphp
				</tr>
				@endforeach
				@foreach($sales as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase">{{ $t->passenger_name }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{$t->sale}}</td>
					<td>{{$t->profit}}</td>
					<td>{{$t->sale}}</td>
					<td>Other Sales</td>
					@php
					if (!is_null($t->sale)) {
						$total = $total + $t->sale;
					}
					if (!is_null($t->profit)) {
						$profit = $profit + $t->profit;
					}

					@endphp
				</tr>
				@endforeach
				@foreach($travel as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase">{{ $t->passenger_name }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{$t->sale}}</td>
					<td>{{$t->profit}}</td>
					<td>{{$t->sale}}</td>
					<td>Travel Insurance</td>
					@php
					if (!is_null($t->sale)) {
						$total = $total + $t->sale;
					}
						if (!is_null($t->profit)) {
						$profit = $profit + $t->profit;
					}

					@endphp
				</tr>
				@endforeach
					@foreach($umrah as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase">{{ $t->passenger_name }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{$t->sale}}</td>
					<td>{{$t->profit}}</td>
					<td>{{$t->sale}}</td>
					<td>Umrah Sale</td>
					@php
					if (!is_null($t->sale)) {
						$total = $total + $t->sale;
					}
						if (!is_null($t->profit)) {
						$profit = $profit + $t->profit;
					}

					@endphp
				</tr>
				@endforeach
				@foreach($hotels as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase">{{ $t->passenger_name }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{$t->sale}}</td>
					<td>{{$t->profit}}</td>
					<td>{{$t->sale}}</td>
					<td>Hotel Sale</td>
					@php
					if (!is_null($t->sale)) {
						$total = $total + $t->sale;
					}
						if (!is_null($t->profit)) {
						$profit = $profit + $t->profit;
					}

					@endphp
				</tr>
				@endforeach
				@foreach($packages as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
					<td class="text-uppercase">{{ $t->passenger_name }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $t->party->name }}</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{$t->sale}}</td>
					<td>{{$t->profit}}</td>
					<td>{{$t->sale}}</td>
					<td>Tour Packages</td>
					@php
					if (!is_null($t->sale)) {
						$total = $total + $t->sale;
					}
						if (!is_null($t->profit)) {
						$profit = $profit + $t->profit;
					}

					@endphp
				</tr>
				@endforeach
				@endif
			</tbody>
			<tfoot>
				<tr>
					<th colspan="7" style="text-align: right;">Total</th>
					<td>&pound;{{number_format($total,2)}}</td>
					<td>&pound;{{number_format($profit,2)}}</td>
					<td>&pound;{{number_format($total,2)}}</td>
				</tr>
			</tfoot>
		</table>
	</div>

</div>
</section>
</div>

@endsection

@push('script')
<script type="text/javascript">
	$(function(){

	});
</script>
@endpush
