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
    	<li class="active">Daily Logs</li>
    </ol>
 </section>
 <section class="content">
 	<div class="box">
 		<div class="box-header with-border">
 			<h2 class="text-center"><b>Daily Logs</b></h2>
 		</div>
 		<div class="box-body">
 		{{-- 	<div id="demo" class="collapse in" aria-expanded="true" >
 				<form class="form-validation" method="GET">
 					<div class="filters">
 						<div class="row">

 							<div class="col-md-3 form-group">
 								<div class="row tasks-dates">
 									<div class="col-md-6">
 										<label>Dates Between</label>
 										<input type="text" name="date_start" placeholder="From" autocomplete="off" class="form-control Searchdatepicker" value="{{request()->has('date_start')?request()->get('date_start'):''}}"> 
 									</div>
 									<div class="col-md-6">
 										<label>&nbsp;</label>
 										<input type="text" name="date_end" autocomplete="off" placeholder="To" class="form-control Searchdatepicker" value="{{request()->has('date_end')?request()->get('date_end'):''}}">
 									</div>
 								</div>
 							</div>
						<div class="col-md-2 form-group">
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
								<option value="ticket">Tickets</option>
								<option value="hotel_sales">Hotel Sales</option>
								<option value="tour_package">Tour Package</option>
								<option value="umrah_sales">Umrah Sales</option>
								<option value="travel_insurance">Travel Insurance</option>
								<option value="other_sales">Other Sales</option>
							</select>
						</div>
						<div class="col-md-1 form-group">
							<label>&nbsp;</label><br>
							<input type="submit" class="btn btn-success" value="Search">
						</div>

					</div>
				</div>
			</form>
		</div> --}}
		<div class="filtered-params"> <h3>{{request()->has('date_start') && !empty(request()->get('date_start'))?' | '.request()->get('date_start').' To '.request()->get('date_end'):''}}</h3></div>
		<table class="table table-bordered income-table">
			<thead>
				<tr>
					<th>Created at</th>
					<th>Type</th>
					<th>Staff</th>
					<th>Passenger Name</th>
					<th>Sale</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1;$total=0; @endphp
				@foreach($tickets as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Ticket</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->surname }} {{ $t->given_name }}</td>
					<td>{{!is_null($t->trans)?$t->trans->sale:''}}</td>
				</tr>
				@endforeach
				@foreach($sales as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Other Sales</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->passenger_name }}</td>
					<td>{{$t->sale}}</td>
				</tr>
				@endforeach
				@foreach($travel as $t)
				<tr>
						<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Travel Insurance</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->passenger_name }}</td>
					<td>{{$t->sale}}</td>
				</tr>
				@endforeach
					@foreach($umrah as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Umrah Sale</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->passenger_name }}</td>
					<td>{{$t->sale}}</td>
				</tr>
				@endforeach
				@foreach($hotels as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Hotel Sale</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->passenger_name }}</td>
					<td>{{$t->sale}}</td>
				</tr>
				@endforeach
				@foreach($packages as $t)
				<tr>
					<td>{{ date('d M Y',strtotime($t->created_at)) }}</td>
					<td>Tour Packages</td>
					<td>{{ $t->admin->name }}</td>
					<td>{{ $t->passenger_name }}</td>
					<td>{{$t->sale}}</td>
				</tr>
				@endforeach
			</tbody>
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
