@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Flights
          <!--   <a href="{{ url('admin/add-flight') }}" class="btn btn-primary pull-right">Add Flight</a> -->
        </h1>

    </section>
     <section class="content">
         <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
       
                        <form method="get" action="{{url('admin/manage-flights')}}">
                        <div class="row">
                           
                             <div class="col-md-3 form-group">
                                <label>Agents</label>
                                <select name="agent" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($agents as $c)
                                    <option value="{{$c->id}}" {{request()->has('agent') && request()->get('agent') == $c->id?'selected':''}}>{{$c->business_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col-md-3 form-group">
                                <label>Airlines</label>
                                <select name="airline" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($airlines as $c)
                                    <option value="{{$c->id}}" {{request()->has('airline') && request()->get('airline') == $c->id?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col-md-3 form-group">
                                <label>From</label>
                                <select name="from" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->name}}" {{request()->has('from') && request()->get('from') == $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-3 form-group">
                                <label>To</label>
                                <select name="to" class="form-control">
                                    <option value=""> Select</option>
                                    @foreach($cities as $c)
                                    <option value="{{$c->name}}" {{request()->has('to') && request()->get('to') == $c->name?'selected':''}}>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="col-md-3 form-group">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value=""> Select</option>
                                  <option value="0" {{request()->has('type') && request()->get('type') == 0?'selected':''}}>One Way</option>
                                  <option value="1" {{request()->has('type') && request()->get('type') == 1?'selected':''}}> Return</option>
                                </select>
                            </div>
                  
                         
                           <!--    <div class="col-md-3 form-group">
                                <label>By Date</label>
                                <input type="text" name="date" class="form-control datepicker" autocomplete="off" value="{{request()->has('date')?request()->get('date'):''}}"> 
                            </div>
                       -->
                            <div class="col-md-3 form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search" style="margin-right: 10px;"></i> Search</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <table class="table table-borderd table-striped">
              <thead>
                <tr>
                          <th> Agent</th>
                  <th >Airline</th>
                  <th > Departure From</th>
                  <th > Return</th>
                  <!-- <th> Days</th> -->
                  <th >Adult Price</th>
                          <!-- <th>Child Price</th>
                          <th>Infant Price</th> -->
                          <th > Active</th>
                          <!--    <th>Premium?</th> -->
                 <!--          <th >Action</th> -->
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($flights as $f)
                        <tr data-id="{{$f->id}}">

          <td valign="top">
            {{!is_null($f->agent)?$f->agent->business_name:''}}
         <!--    @if (!empty($f->status_remarks))
                <span class="remarks" title="{{ !empty($f->status_remarks)?$f->status_remarks:'N/A' }}">Remarks</span>
                @else
                    N/A
              @endif
 -->

            </td>
                          <td valign="top">

                           <img src="{{url('storage/uploads/airline/'.$f->airline->img)}}" height="30">
                         </td>
                         <td valign="top"  >
                          <span class="text-success" style="font-weight: bolder;">{{ date_format(date_create($f->out_bound_date), 'd-M-Y') }}</span>
                          <div class="row">
                            <div class="col-md-3">
                              {{ $f->first_from  }}
                              {{ date("H:i", strtotime($f->one_way_departure_time)) }}
                            </div>
                            <div class="col-md-1">&#8594; </div>
                            @if (!empty($f->extra_via))
                            <div class="col-md-2">
                              {{ $f->extra_via }}
                              {{ date("H:i", strtotime($f->one_way_arrival_time)) }}
                            </div>
                            <div class="col-md-1">&#8594; </div>
                            @endif
                            <div class="col-md-2">
                              {{ $f->first_to }}
                              @if (!empty($f->extra_via))
                              {{ date("H:i", strtotime($f->extra_one_way_arrival_time1)) }}
                              @else
                              {{ date("H:i", strtotime($f->one_way_arrival_time)) }}
                              @endif
                            </div>
                          </div>
                        </td>
                        <td valign="top" >
                          @if ($f->in_bound_date != "1970-01-01")

                          <span class="text-success" style="font-weight: bolder;">{{ date_format(date_create($f->in_bound_date), 'd-M-Y') }}</span>
                          <div class="row">
                            <div class="col-md-3">
                              {{ $f->return_from }}
                              {{ date("H:i", strtotime($f->return_departure_time)) }}
                            </div>
                            <div class="col-md-1">&#8594; </div>
                            @if (!empty($f->extra_r_via))
                            <div class="col-md-2">
                              {{ $f->extra_r_via}}
                              {{ date("H:i", strtotime($f->return_arrival_time)) }}
                            </div>
                            <div class="col-md-1">&#8594; </div>
                            @endif
                            <div class="col-md-2">
                              {{ $f->return_to }}
                              @if (!empty($f->extra_r_via))
                              {{ date("H:i", strtotime($f->extra_return_arrival_time1))}}
                              @else
                              {{ date("H:i", strtotime($f->return_arrival_time)) }}
                              @endif
                            </div>
                          </div>
                          @endif
                        </td>
            <!-- <td valign="top">
              {{ !empty($f->pnr)?$f->pnr:"N/A" }}
            </td> -->
            <td valign="top">
              {{ $f->cost_price }}
            </td>
   <!--        <td valign="top">
              {{ $f->child_price }}
          </td>
          <td valign="top">
              {{ $f->infant_price }}
          </td> -->


             <td><input type="checkbox" onchange="addToHome(this)"
                                            {{ $f->status == 1?'checked':'' }}><span
                                            class="top<?php echo $f->id; ?>"></span>
                                    </td>

         <!--  <td valign="top" class="text-center">
              <input type="checkbox" id="premium" {{ !empty($f->premium) && $f->premium == 1?'checked':"" }} onClick="UpdatePremium(this, '{{ $f->id}}')"/>
              <br/>
              <span class="premium{{ $f->id  }}"></span>
            </td> -->

        <!--     <td valign="top">

              <a href="{{url('admin/edit-flight-'.$f->id)}}" title="Edit" class="  btn btn-primary btn-xs btn-sm">Edit</a>

            </td> -->
          </tr>
          @endforeach
        </tbody>
      </table>
      {!! $flights->links() !!}
    </div>
  </div>
</div>
</div>
</section>
</div>

@endsection
@push('script')
<script type="text/javascript">
      $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
});
function addToHome(pointer) {

    var $this = $(pointer);
    var tr = $this.closest('tr');
    var id = tr.data('id');

    if ($this.is(':checked')) {
        var is_home = 1;
    } else {
        var is_home = 0;
    }

    $this.prop("disabled", true);
    $this.val("Processing..");

    $.ajax({
        url: SITE_PATH + '/flight-active',
        type: 'GET',
        data: {
            is_home: is_home,
            id: id
        },
        dataType: "JSON",
        success: function(data) {
            if (data.notify) {
                $(".top" + id).html("<span style=\"color:green;font-size:10px;\">Success</span>");
            } else {
                $(".top" + id).html("<span style=\"color:red;font-size:10px;\">Error</span>");
            }
        },
        error: function() {

        },
        complete: function() {
            $this.prop("disabled", false);
        }
    });
}
</script>
@endpush