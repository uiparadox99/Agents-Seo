@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Quotation
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Quotation</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<form action="" method="get">
					<div class="row">
						<div class="col-md-2">
							<label>Date</label>
							<input type="text" name="date" placeholder="From" autocomplete="off" class="form-control datepicker" value="{{request()->has('date')?request()->get('date'):''}}" > 
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
			<div class="box-header with-border">
				<div class="box-tools pull-right">
					<a href="{{ route('generate-quotation') }}" class="btn btn-primary btn-block">Generate Invoice</a>
				</div>
				<div class="clearfix"></div>
			<br>
			</div>
			<div class="box-body">
				<table class="table table-bordered quote-datatable">
					<thead>
						<tr>
							<th width="7%">Sr No.</th>
							{{-- <th>Invoice No</th> --}}
							<th>Date</th>
							<th>Passenger Detail</th>
							{{-- <th>Tickets</th> --}}
							<th width="7%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($invoices as $c)
						@php $detail = json_decode($c->data); @endphp
						<tr>
							<td>{{ $i++ }}</td>
							{{-- <td>{{ $c->ref }}</td> --}}
							<td>{{ date('d M Y',strtotime($c->date)) }}</td>
							<td>{!! $detail->party !!}</td>
							{{-- <td>{{isset($detail->ticket_no)?implode(',',$detail->ticket_no):''}}</td> --}}
							<td>
								<a href="{{ route('edit-quotation', $c->id) }}" class="btn btn-primary btn-sm">Edit</a>
								<a href="{{ route('download-quotation', $c->id) }}" class="btn btn-success btn-sm">PDF</a>
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
	$(".quote-datatable").DataTable({
            "ordering": false
        });
</script>
@endpush