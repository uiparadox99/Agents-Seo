@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Status
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Status</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Manage Status</h3>
				<div class="box-tools pull-right">
					<a href="{{ route('add-status') }}" class="btn btn-danger btn-sm btn-block">Add Status</a>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th width="6%">Sr No.</th>
							<th>Name</th>
							<th>Type</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($status as $f)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $f->name }}</td>
							<td>{{ $f->type }}</td>
							<td>
								<a href="{{ route('edit-status', $f->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
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

</script>
@endpush
