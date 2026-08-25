@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Reservations
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Reservations</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<form action="" method="get">
					<div class="row">
						<div class="col-md-2">
							<label>Reservation Code</label>
							<input type="text" name="code" class="form-control" placeholder="No" value="{{request()->has('code')?request()->get('code'):''}}">
						</div>
						<div class="col-md-2">
							<label>Date From</label>
							<input type="text" name="date" placeholder="From" autocomplete="off" class="form-control datepicker" value="{{request()->has('date')?request()->get('date'):''}}" > 
						</div>
							<div class="col-md-2">
							<label>Date To</label>
							<input type="text" name="date_to" placeholder="to" autocomplete="off" class="form-control datepicker" value="{{request()->has('date_to')?request()->get('date_to'):''}}" > 
						</div>
							<div class="col-md-2">
							<label>Passenger</label>
							<input type="text" name="passenger" class="form-control" placeholder="passenger" value="{{request()->has('passenger')?request()->get('passenger'):''}}">
						</div>
						<div class="col-md-1">
							<label>&nbsp;</label>
							<button type="submit" class="btn btn-success btn-block">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="box">
			<div class="box-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home" class="btn-primary">PNR Booking</a></li>
					<li><a data-toggle="tab" class="btn-warning" href="#menu1">Quotation Generator</a></li>
				  </ul>
				  <div class="tab-content">
					<div id="home" class="tab-pane fade in active">
				<form action="{{url('admin/download-auto-reservation')}}" method="get" class="auto-g">
					<br>
					<div class="row">
						<div class="col-md-10">
							<label>Command to auto generate (Please line break for each passenger and flight)</label>
							<textarea name="command" class="form-control" required rows="10"></textarea>
						</div>
						<div class="col-md-2 text-center">
							<br>
							<br>
							<button onclick="$('.auto-g').submit()" class="btn btn-primary">Auto Fill PDF Download</button>
						
						</div>
					</div>
				</form>
					</div>
				<div id="menu1" class="tab-pane fade">
					<form action="{{url('admin/download-auto-quotation')}}" method="get" class="auto-c-g">
						<br>
						<div class="row">
							<div class="col-md-5">
								<label>Command to auto generate (Please line break for each flight)</label>
								<textarea name="command" class="form-control" required rows="8"></textarea>
							</div>
							<div class="col-md-5">
								<div class="row">
									<div class="col-md-6 form-group">
										<label class="">No of Adults </label>
										<input type="number" class="form-control" value="0" name="no_adults" id="no_adults" placeholder="No" onchange="calculatePrice(this)">
									</div>
									<div class="col-md-6 form-group">
										<label class="">Adult Price </label>
										<input type="text" class="form-control"  value="0" name="adult_price" id="adult_price" placeholder="price" onchange="calculatePrice(this)">
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label class="">No of Childs </label>
										<input type="number" class="form-control"  value="0" name="no_childs" id="no_childs" placeholder="No" onchange="calculatePrice(this)">
									</div>
									<div class="col-md-6 form-group">
										<label class="">Child Price </label>
										<input type="text" class="form-control"  value="0" name="child_price" id="child_price" placeholder="price" onchange="calculatePrice(this)">
									</div>
								</div>
								<div class="form-group">
									<label class="">Total Price </label>
									<input name="total_price" id="total_price" class="form-control" placeholder="Total Price">
								</div>
							</div>
							<div class="col-md-2 text-center">
								<br>
								<br>
								<button onclick="$('.auto-c-g').submit()" class="btn btn-primary">Auto Fill PDF Download</button>
							
							</div>
						</div>
					</form>
				  </div>
				</div>
				<br>
				<div class="text-right">

					<a href="{{ route('generate-reservation') }}" class="btn btn-danger">Manual Reservation</a>
				</div>
				<br>
				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th width="7%">Sr No.</th>
							<th>Code</th>
							<th>Airlines Code</th>
							<th>Date From</th>
							<th>Date To</th>
							<th>Passenger</th>
							<th width="7%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($invoices as $c)
						@php $detail = json_decode($c->data); @endphp
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $c->code }}</td>
							<td>{{ $c->airline_res_code }}</td>
							<td>{{ date('d M Y',strtotime($c->date_from)) }}</td>
							<td>{{ date('d M Y',strtotime($c->date_to)) }}</td>
							<td>{{$c->passenger_name}}</td>
							<td>
								<a href="{{ route('download-reservation', $c->id) }}" class="btn btn-success btn-sm">PDF</a>
							</td>
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
<script>
	function calculatePrice(event){
		var adult_price = $('#adult_price').val();
		var no_adults = $('#no_adults').val();
		var adt_p = parseInt(parseInt(adult_price) * parseInt(no_adults));

		var child_price = $('#child_price').val();
		var no_childs = $('#no_childs').val();
		var child_p = parseInt(parseInt(child_price) * parseInt(no_childs));

		var total_price = parseInt(parseInt(child_p) + parseInt(adt_p));
		
		$('#total_price').val(total_price);
		
	}
</script>
@endpush