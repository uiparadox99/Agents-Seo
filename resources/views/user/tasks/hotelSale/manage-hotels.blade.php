@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
   @include('user.tasks.includes.header-links')
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h2 class="text-center m-0"><b>Manage Hotel Sales</b> {{request()->has('date_start') && !empty(request()->get('date_start'))?' | '.request()->get('date_start').' To '.request()->get('date_end'):''}}</h2>
            <div class="box-tools pull-right">
               <!--<a href="{{ route('add-hotel-sale') }}" class="btn btn-danger btn-sm btn-block">Add Hotel Sale</a>-->
            </div>
         </div>
         <div class="box-body">
         	<div id="demo" class="" aria-expanded="true" >
				<form class="form-validation" action="" method="GET">
				<div class="filters">
					<div class="row">
												
						<div class="col-md-3 form-group">
							<div class="row tasks-dates">
								<div class="col-md-6">
									<label>Dates Between</label>
									<input type="text" name="date_start" placeholder="From" autocomplete="off" class="form-control  datepicker" value="{{request()->has('date_start')?request()->get('date_start'):''}}"> 
								</div>
								<div class="col-md-6">
									<label>&nbsp;</label>
									<input type="text" name="date_end" autocomplete="off" placeholder="To" class="form-control datepicker" value="{{request()->has('date_end')?request()->get('date_end'):''}}">
								</div>
							</div>
						</div>

						<div class="col-md-3 form-group">
							<label>Hotel Name</label>
							<input type="text" name="hotel_name" class="form-control" value="{{request()->has('hotel_name')?request()->get('hotel_name'):''}}">
						</div>

						<div class="col-md-3 form-group">
							<label>Party</label>
							<select name="party" class="form-control validate[required] select2">
								<option value="">All</option>
								@foreach($parties as $p)
								<option value="{{ $p->id }}" {{request()->has('party') && request()->get('party') == $p->id?'selected':''}}>{{ $p->name }}</option>
								@endforeach
							</select>
						</div>

                        <div class="col-md-2 form-group">
                            <label>Supplier</label>
                            <select name="supplier" class="form-control validate[required]">
                                <option value="">All</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{request()->has('supplier') && request()->get('supplier') == $s->id?'selected':''}}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

						@if (auth()->user()->type == 'admin')
						@endif

						<div class="col-md-1 form-group">
							<label>&nbsp;</label><br>
							<input type="submit" class="btn btn-success" value="Search">
						</div>

					</div>
				</div>
			</form>
			</div>
			<hr>
            <table class="table table-bordered datatables">
            	<thead>
            		<tr>
            			<th width="5%">Sr No.</th>
            			<th>Report Date</th>
                        <th>Passenger Name</th>
                        <th>Hotel Name</th>
                        <th>Party</th>
                        <th>Phone</th>
                        <th>Supplier</th>
            			<th>Actions</th>
            		</tr>
            	</thead>
            	<tbody>
            				@if(request()->has('date_start') && !empty(request()->get('date_start')))
						@php $i = 1; @endphp
						@foreach($hotels as $t)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ date('d M Y',strtotime($t->report_date)) }}</td>
							<td>{{ $t->passenger_name }} {{ $t->surname }}</td>
                            <td>{{ $t->hotel_name }}</td>
                            <td>{{ $t->party->name }}</td>
                            <td>{{ $t->phone }}</td>
                            <td>{{ $t->supplier->name }}</td>
                            <td> <a href="{{ url('edit-hotel-sale').'/'.$t->id }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a></td>
						</tr>
						@endforeach
						@endif
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
