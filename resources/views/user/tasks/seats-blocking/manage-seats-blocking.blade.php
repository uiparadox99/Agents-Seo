@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container"> 
	<section class="content-header">
		<h1>
			Manage Cities
		</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Cities</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Manage Cities</h3>
				<div class="box-tools pull-right">
					<a href="{{ route('add-citiy') }}" class="btn btn-danger btn-sm btn-block">Add City</a>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-bordered datatables">
					<thead>
						<tr>
							<th width="9%">Airline</th>
							<th width="7%">PNR</th>                        
							<th width="10%">Status</th>                        
							<th width="7%">Seats</th>
							<th width="9%">Flight #</th>
							<th width="10%">From</th>
							<th width="10%">To</th>
							<th width="10%">Date</th>
							<th width="7%">Departure</th>
							<th width="7%">Arrival</th>
							<th width="7%">Cost</th>
							<th width="7%">Available</th>                     
							<th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
                    @php
	                    $out_bound_date 		= "";
	                    $totalAvailableSeats 	= 0;
                    @endphp

                    @foreach($blocks as $r)
                    
	                    @if($out_bound_date != $r->out_bound_date)
	                    	@php
			                    $out_bound_date = $r->out_bound_date;
			                    $randColor = rand_color();
			                    $out_bound_date_color = "background-color:" . $randColor ;
		                    @endphp
                    	@endif

	                    @if(stristr($r->pnr, 'test') === false)
	                    	@php
	                    		$totalAvailableSeats += ($r->available_seats == "")? $r->seats : $r->available_seats;
	                    	@endphp
                    	@endif
                    
                        

                        <tr>
                            <td>
                                @if(!empty($r->logo))
                                <img src="uploads/<?php echo $r->logo; ?>" class="" style="width: 100px;"/>
                                @else
                                {{ $r->airline }}
                                @endif
                            </td>
                            <td><a href="seats-blocking-form.php?id=<?php echo $r->id; ?>"><?php echo $r->pnr; ?></a></td>
                            <td style="text-transform: capitalize; position: relative;<?php echo ($r->status == "time_limit")?"color: #F90015;": ""; ?>">
                                
                                @switch($r->status)
                                	@case("time_limit")
                                	{{ "Time Limit " }}<br/>
                                	{{ date("d-M-Y H:i", strtotime($r->status_date_time)) }}
                                	{{ !empty($r->payment_percentage)?"<br/><span style='color: blue; font-weight: bold;'>".$r->payment_percentage." %</span>":"" }}
                                	@break
                                	@case("ticketed")
                                	{{ "Ticketed" }}
                                	@break
                                	@case("name_updated")
                                	{{ "Name Updated" }}
                                	@break
                                	@case("posted")
                                	{{ "Posted" }}
                                	@break
                                	@case("final")
                                	{{ 'Final' }}
                                	@break
                                	@default:
                                	{{ 'N/A' }};
                              	@endswitch

                               
                                <a class="update-status" onclick="SetModalData(this)" href="javascript: void(0);" 
                                data-sector="{{ $r->from_city." - ".$r->to_city }}" 
                                data-outbound-date="{{ date("d-M-Y", strtotime($r->out_bound_date)) }}" data-flight-number="{{ $r->flight_number }}" 
                                data-pnr="{{ $r->pnr }}" 
                                data-id="{{ $r->id }}" 
                                data-status="{{ $r->status }}" 
                                data-remarks='{{ !empty($r->status_remarks) && $r->status_remarks != "null"? $r->status_remarks : "" }}' 
                                data-date="{{ ($r->status_date_time != "0000-00-00 00:00:00")?date("d-M-Y", strtotime($r->status_date_time)):"" }}" 
                                data-hours="{{ ($r->status_date_time != "0000-00-00 00:00:00")?date("H", strtotime($r->status_date_time)):"" }}" 
                                data-minutes="{{ ($r->status_date_time != "0000-00-00 00:00:00")?date("i", strtotime($r->status_date_time)):"" }}" 
                                data-toggle="modal" 
                                data-target="#myModal"><i class="fa fa-edit"></i></a>
                                
                            </td>
                            <td>
                            	<a href="seats-blocking-form.php?id={{ $r->id }}">{{ $r->seats }}</a>
                            </td>
                            <td>
                                {{ $r->flight_number }}
                                {{ ($r->one_way_or_return)?"<br/>".$r->extra_r_flight_code1:"" }}
                            </td>
                            <td>
                                <?php echo $r->from_city; ?>
                                <?php echo ($r->one_way_or_return)?"<br/>".$r->to_city:"" ?>
                            </td>
                            <td>
                                {{ $r->to_city }}
                                {{ ($r->one_way_or_return)?"<br/>".$r->from_city:"" }}
                            </td>
                            <td style="<?php echo $out_bound_date_color; ?> ; color: #FFF; font-weight: bold;">
                                {{ date("d-M-Y", strtotime($r->out_bound_date)) }}
                                 {{ ($r->one_way_or_return)?date("d-M-Y", strtotime($r->in_bound_date)):"" }}
                            </td>
                            <td>
                                {{ date("H:i", strtotime($r->one_way_departure_time)) }}

                                {{ ($r->one_way_or_return)?"<br/>".date("H:i", strtotime($r->return_departure_time)):"" }}
                            </td>
                            <td>
                                {{ date("H:i", strtotime($r->one_way_arrival_time)) }}
                                {{ ($r->one_way_or_return)?"<br/>".date("H:i", strtotime($r->return_arrival_time)):"" }}
                            </td>
                            <td>Rs {{ $r->cost_price }} </td>
                            <td style="{{ $out_bound_date_color }} ; font-weight: bold; color: #FFF;">
                            	{{ ($r->available_seats == "")? $r->seats : $r->available_seats }}
                            </td>
                                                       
                            <td>
                                <a href="{{ route('edit-airline-block', $r->id) }}" ><i class="fa fa-edit"></i></a>
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