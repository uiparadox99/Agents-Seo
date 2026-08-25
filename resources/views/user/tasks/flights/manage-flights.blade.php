@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Sectors
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Sectors</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Manage Sectors</h3>
				<div class="box-tools pull-right">
					<a href="{{ route('add-flight') }}" class="btn btn-danger btn-sm btn-block">Add Sector</a>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered flightsTable">
					<thead>
						<tr>
							<th width="6%">Sr No.</th>
							<th>Flight Number</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($flights as $f)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $f->name }}</td>
							<td>
								<a href="{{ route('edit-flight', $f->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
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
<script type="text/javascript">
$("table.flightsTable").DataTable({
            "ordering": false
        });
</script>
@endpush
