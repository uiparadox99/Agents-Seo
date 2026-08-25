  @foreach($flights as $f)
                    <tr data-id="{{$f->id}}" style="border-color: orange;   border: 1px solid #f58220; ">
                        <td valign="top">
                          @if(!empty($f->airline->img))
                         <img src="{{url('storage/uploads/airline/'.$f->airline->img)}}" style="width: 100%">
                          @else
                         <img src="{{url('images/placeholder.jpg')}}" style="width: 100%">
                         @endif
                        <div class="mt-2 text-center"><strong> Rs.{{ $f->cost_price }} </strong></div>
                        <div class="mt-2 text-center" style="font-size: 12px"><strong> {{ date_format(date_create($f->created_at), 'd-M-Y') }}</strong></div>
                     </td>
                     <td valign="top"  width="80%" style="vertical-align: middle;">
                       <!-- <span class="pull-right" style="float: right;">| child : Rs.{{ $f->child_price }} | Infant : Rs.{{ $f->infant_price}}</span></span> -->
                      <div class="row">
                        <div class="col-md-2">
                     
                          <strong>{{$f->flight_number}}</strong>
                  
                        </div>
                        <div class="col-md-2 text-center">
                         <span class="text-success" style="font-weight: bold;"> {{ date_format(date_create($f->out_bound_date), 'd-M-Y') }}</span>
                        </div>
                        <div class="col-md-3 text-center">
                          <span class="text-warning" style="font-weight:bold">{{$f->first_from}}</span> <span  style="float: right;">-</span>
                        </div>
                       
                   
                      <div class="col-md-3 text-center">
                        @if(!empty($f->extra_via))
                        <span class="text-warning" style="font-weight:bold">{{$f->extra_via}}</span>
                        @else
                        <span class="text-warning" style="font-weight:bold">{{$f->first_to}}</span>
                        @endif
                      </div>
                      <div class="col-md-1 text-center">
                         {{ date("H:i", strtotime($f->one_way_departure_time)) }}
                      </div>
                        <div class="col-md-1 text-center">
                        {{ date("H:i", strtotime($f->one_way_arrival_time)) }}
                      </div>
                    </div>
                     @if(!empty($f->extra_via))
                      <div class="row">
                        <div class="col-md-2">
                          <strong>{{$f->extra_flight_code1}}</strong>
                     
                        </div>
                        <div class="col-md-2 text-center">
                           <span class="text-success" style="font-weight: bold;">  @if($f->extra_trancend_date  == 'same')
                          {{ date_format(date_create($f->out_bound_date), 'd-M-Y') }}
                          @else 
                                {{ date('d M Y', strtotime($f->out_bound_date." +1 day") )}}
                          @endif</span>
                        </div>
                        <div class="col-md-3 text-center">
                          <span class="text-warning" style="font-weight:bold">{{$f->extra_via}}</span> <span  style="float: right;">-</span>
                        </div>
                       
                   
                      <div class="col-md-3 text-center">
             
                        <span class="text-warning" style="font-weight:bold">{{$f->first_to}}</span>
               
                      </div>
                      <div class="col-md-1 text-center">
                         {{ date("H:i", strtotime($f->extra_one_way_departure_time1)) }}
                      </div>
                        <div class="col-md-1 text-center">
                        {{ date("H:i", strtotime($f->extra_one_way_arrival_time1)) }}
                      </div>
                    </div>
                    @endif
                   
            
               @if ($f->one_way_or_return == 1)
                  <br>
               <div class="row">
                        <div class="col-md-2">
                     
                          <strong>{{$f->return_flight_number}}</strong>
                  
                        </div>
                        <div class="col-md-2 text-center">
                            <span class="text-success" style="font-weight: bold;"> {{ date_format(date_create($f->in_bound_date), 'd-M-Y') }}</span>
                        </div>
                        <div class="col-md-3 text-center">
                          <span class="text-warning" style="font-weight:bold">{{$f->return_from}}</span> <span  style="float: right;">-</span>
                        </div>
                       
                   
                      <div class="col-md-3 text-center">
                        @if(!empty($f->extra_via))
                        <span class="text-warning" style="font-weight:bold">{{$f->extra_r_via}}</span>
                        @else
                        <span class="text-warning" style="font-weight:bold">{{$f->return_to}}</span>
                        @endif
                      </div>
                      <div class="col-md-1 text-center">
                         {{ date("H:i", strtotime($f->return_departure_time)) }}
                      </div>
                        <div class="col-md-1 text-center">
                        {{ date("H:i", strtotime($f->return_arrival_time)) }}
                      </div>
                    </div>
                     @if(!empty($f->extra_r_via))
                      <div class="row">
                        <div class="col-md-2">
                          <strong>{{$f->extra_r_flight_code1}}</strong>
                     
                        </div>
                        <div class="col-md-2 text-center">
                           <span class="text-success" style="font-weight: bold;">  @if($f->extra_r_trancend_date  == 'same')
                          {{ date_format(date_create($f->in_bound_date), 'd-M-Y') }}
                          @else 
                                {{ date('d M Y', strtotime($f->in_bound_date." +1 day") )}}
                          @endif</span>
                        </div>
                        <div class="col-md-3 text-center">
                          <span class="text-warning" style="font-weight:bold">{{$f->extra_r_via}}</span> <span  style="float: right;">-</span>
                        </div>
                       
                   
                      <div class="col-md-3 text-center">
             
                        <span class="text-warning" style="font-weight:bold">{{$f->return_to}}</span>
               
                      </div>
                      <div class="col-md-1 text-center">
                         {{ date("H:i", strtotime($f->extra_return_departure_time1)) }}
                      </div>
                        <div class="col-md-1 text-center">
                        {{ date("H:i", strtotime($f->extra_return_arrival_time1)) }}
                      </div>
                    </div>
        
              @endif
              @endif
              </td>

          <td valign="top">


            <div class="text-center">
            <span style="font-size: 12px">Active</span>
     </div>
            <div class="text-center">
                <input type="checkbox" onchange="addToHome(this)"
                                            {{ $f->status == 1 && !request()->has('old')?'checked':'' }}><span
                                            class="top<?php echo $f->id; ?>"></span>
       
           <br>
            <a href="{{url('agent-edit-flight-'.$f->id)}}" title="Edit" class="  btn btn-primary btn-xs btn-sm">Edit</a>
                <br>
            <a href="{{url('agent-edit-flight-'.$f->id.'?copy=true')}}" title="copy" class="  btn btn-warning btn-xs btn-sm">Copy</a>
                </div>


        </td>
    </tr>
    @endforeach