@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Star Currency Invoices
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Star Currency Invoices</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<form action="" method="get">
					<div class="row">
						<div class="col-md-2">
							<label>Invoice No</label>
							<input type="text" name="ref" class="form-control" placeholder="No" value="{{request()->has('ref')?request()->get('ref'):''}}">
						</div>
						<div class="col-md-2">
							<label>Date</label>
							<input type="text" name="date" placeholder="From" autocomplete="off" class="form-control datepicker" value="{{request()->has('date')?request()->get('date'):''}}" > 
						</div>
							<div class="col-md-2">
							<label>Customer</label>
							<input type="text" name="passenger" class="form-control" placeholder="Customer" value="{{request()->has('passenger')?request()->get('passenger'):''}}">
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
			<div class="box-header with-border">
				<div class="box-tools pull-right">
					<a href="{{ route('generate-currency-invoice') }}" class="btn btn-primary btn-block">Generate Invoice</a>
				</div>
				<div class="clearfix"></div>
			<br>
			</div>
			<div class="box-body">
				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th width="7%">Sr No.</th>
							<th>Invoice No</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th>Customer Phone</th>
							<th>Currency Received</th>
							<th>Currency Paid</th>
							<th width="7%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($invoices as $c)
						@php $detail = json_decode($c->data); @endphp
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $c->ref }}</td>
							<td>{{ date('d M Y',strtotime($c->date)) }}</td>
							<td>{!! $detail->customer_name !!}</td>
							<td>{!! $detail->customer_phone !!}</td>
							<td>{!! $detail->c_received !!}</td>
							<td>{!! $detail->c_paid !!}</td>
							<td>
								<a href="{{ route('edit-currency-invoice', $c->id) }}" class="btn btn-primary btn-sm">Edit</a>
								<a href="{{ route('download-currency-invoice', $c->id) }}" class="btn btn-success btn-sm">PDF</a>
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

@endpush