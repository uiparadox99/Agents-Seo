@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Employees
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Employees</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Manage Employees</h3>
				<div class="box-tools pull-right">
					<a href="{{ route('add-employee') }}" class="btn btn-danger btn-sm btn-block">Add Employee</a>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th width="5%">Sr No.</th>
							<th width="20%">Name</th>
							<th>Email</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($admins as $a)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $a->name }}</td>
							<td>{{ $a->email }}</td>
							<td>
								<a href="{{ route('edit-employee', $a->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
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