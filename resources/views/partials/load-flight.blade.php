@if(!$detect->isMobile())

    @foreach($flights as $pr)
        <tr>
          <td {{$pr->one_way_or_return == 1?'rowspan=2':''}}>
            @if(!is_null($pr->airline) && !empty($pr->airline->img))
            <img src="{{url('storage/uploads/airline/'.$pr->airline->img)}}" class="img-responsive"
              style="width: 100px;height: 48px;">
            @else
            <img src="//placehold.it/150x150" style="height: 50px;">
            @endif
            <br>
            @if(!empty($pr->extra_via))
            <!--<a href="javascript:;" data-toggle="modal" data-target="#myModal{{$pr->id}}"-->
            <!--  style="color: #f58220;text-decoration: underline;display:block"> <!-- {{$pr->extra_via}} One Stop</a>
            <!--@if(!empty($pr->extra_r_via))-->
            <!--<hr style="margin: 0;">-->
            <!--<a href="javascript:;" data-toggle="modal" data-target="#myModal{{$pr->id}}"-->
            <!--  style="color: #f58220;text-decoration: underline;"> <!-- {{$pr->extra_r_via}} One Stop</a>
            <!--  <br>{{ getTimeDiff($pr->return_arrival_time, $pr->extra_return_departure_time1) }}-->
            <!--@endif-->
            <div class="modal" id="myModal{{$pr->id}}">
              <div class="modal-dialog" style="max-width: 831px">
                <div class="modal-content">
        
        
                  <div class="modal-header">
                    <h4 class="modal-title">Flight Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
        
                  <!-- Modal body -->
                  <div class="modal-body" style="    padding: 0 18px;">
                    <div class="dropdown-detail row">
                  
                      <div class="col-md-2 col-1 pr-0 number-style text-center">
                        {{$pr->flight_number}}
                      </div>
                      <div class="col-md-2 col-2 number-style text-center" style="padding: 0;">
                        {{ date_format(date_create($pr->out_bound_date), 'd M Y')}}
                      </div>
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->first_from}}</strong><br>
                      </div>
                      @if(!empty($pr->extra_via))
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->extra_via}}</strong><br>
                      </div>
                      <div class="col-md-1 col-1">
                        <strong>{{ date("H:i", strtotime($pr->one_way_departure_time)) }}</strong>
                      </div>
                      <div class="col-md-1 col-1" style="padding: 0;">
                        {{ date("H:i", strtotime($pr->one_way_arrival_time)) }}
                      </div>
                      <!-- Stop Flight Detail -->
                      <div class="clearfix"></div>
                      <div class="col-md-12 text-center mt-3 mb-3">
                          <span class="btn btn-primary btn-sm">Connection Time: {{ getTimeDiff($pr->one_way_arrival_time, $pr->extra_one_way_departure_time1) }}</span>
                      </div>
                      <!--             <div class="col-md-2 col-12"></div> -->
                      <div class="col-md-2  text-center col-1 pr-0 number-style">
                        {{$pr->extra_flight_code1}}
                      </div>
                      <div class="col-md-2 col-2 text-center number-style" style="padding: 0">
                        @if($pr->extra_trancend_date != "same" && !empty($pr->extra_via))
        
                        {{ date('d M Y', strtotime($pr->out_bound_date." +1 day") )}}
                        @else
                        {{ date('d M Y', strtotime($pr->out_bound_date) )}}
                        @endif
                      </div>
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->extra_via}}</strong><br>
                      </div>
                      @endif
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->first_to}}</strong><br>
                      </div>
                      <div class="col-md-1 col-1">
                        @if(!empty($pr->extra_via))
                        <strong>{{ date("H:i", strtotime($pr->extra_one_way_departure_time1)) }}</strong>
                        @else
                        <strong>{{ date("H:i", strtotime($pr->one_way_departure_time)) }}</strong>
                        @endif
                      </div>
                      <div class="col-md-1 col-1" style="padding: 0;">
                        @if(!empty($pr->extra_via))
                        {{ date("H:i", strtotime($pr->extra_one_way_arrival_time1)) }}
                        @else
                        {{ date("H:i", strtotime($pr->one_way_arrival_time)) }}
                        @endif
                      </div>
                    </div>
                    @if($pr->one_way_or_return == 1)
                    <hr style="margin: 0 auto;border-bottom: 2px solid #070c39;width: 79%;">
                    <div class="dropdown-detail row">
                
                      <div class="col-md-2  text-center col-1 number-style pr-0">
                        {{$pr->return_flight_number}}
                      </div>
                      <div class="col-md-2 text-center number-style col-2" style="padding: 0">
                        <span class="fa fa-calendar"></span>
                        {{ date('d M Y', strtotime($pr->in_bound_date)) }}
                      </div>
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->return_from}}</strong><br>
                      </div>
                      <!-- show if via retuen -->
                      @if(!empty($pr->extra_r_via))
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->extra_r_via}}</strong><br>
                      </div>
                      <div class="col-md-1 col-1">
                        <strong>{{ date("H:i", strtotime($pr->return_departure_time))}}</strong>
                      </div>
                      <div class="col-md-1 col-1" style="padding: 0;">
                        {{ date("H:i", strtotime($pr->return_arrival_time)) }}
                      </div>
                      <!-- Stop Flight Detail -->
                      <div class="clearfix"></div>
                      <div class="col-md-12 text-center mt-3 mb-3">
                          <span class="btn btn-primary btn-sm">Connection Time: {{ getTimeDiff($pr->return_arrival_time, $pr->extra_return_departure_time1) }}</span>
                      </div>
                      <!-- <div class="col-md-2 col-12">
                             </div> -->
                      <div class="col-md-2  text-center pr-0 number-style col-1">
                        {{$pr->extra_r_flight_code1}}
                      </div>
                      <div class="col-md-2 number-style text-center col-2" style="padding: 0">
                        @if($pr->extra_r_trancend_date != "same" && !empty($pr->extra_r_via))
                        <span class="fa fa-calendar"></span>
                        {{ date('d M Y', strtotime($pr->in_bound_date. " +1 day") ) }}
                        @else
                        <span class="fa fa-calendar"></span>
                        {{ date('d M Y', strtotime($pr->in_bound_date) ) }}
                        @endif
                      </div>
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->extra_r_via}}</strong><br>
                      </div>
                      @endif
                      <div class="col-md-3 col-1">
                        <strong>{{$pr->return_to}}</strong><br>
                      </div>
                      <div class="col-md-1 col-1">
                        @if(!empty($pr->extra_r_via))
                        <strong>{{ date("H:i", strtotime($pr->extra_return_departure_time1)) }}</strong>
                        @else
                        <strong>{{ date("H:i", strtotime($pr->return_departure_time)) }}</strong>
                        @endif
                      </div>
                      <div class="col-md-1 col-1" style="padding: 0;">
                        @if(!empty($pr->extra_via))
                        {{ date("H:i", strtotime($pr->extra_return_arrival_time1)) }}
                        @else
                        {{ date("H:i", strtotime($pr->return_arrival_time)) }}
                        @endif
                      </div>
                    </div>
                    @endif
                  </div>
        
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
        
                </div>
              </div>
            </div>
            @else
             <span class="text-success btn-block mt-3">Direct Flight</span>
            @endif
            <!-- {{$pr->remarks}} -->
          </td>
          <td>{{$pr->flight_number}}
              @if(!empty($pr->extra_via))
              <a  href="javascript:;" data-toggle="modal" data-target="#myModal{{$pr->id}}" class="btn btn-primary btn-sm d-block mt-1 mb-1">Connection Time: {{ getTimeDiff($pr->one_way_arrival_time, $pr->extra_one_way_departure_time1) }}</a>
              {{$pr->extra_flight_code1}}
              @endif
        
          </td>
          <td>{{$pr->first_from}} <br> {{ date("H:i", strtotime($pr->one_way_departure_time)) }}</td>
        
          <td>{{$pr->first_to}} <br> {{ date("H:i", strtotime($pr->one_way_arrival_time)) }}</td>
          <td>{{ date("d M Y", strtotime($pr->out_bound_date))}}</td>
          <td {{$pr->one_way_or_return == 1?'rowspan=2':''}}>{{$pr->cost_price}}</td>
          <td class="text-capitalize" {{$pr->one_way_or_return == 1?'rowspan=2':''}}>{!!!empty($pr->refundable) && $pr->refundable == 'yes'?'Refundable':'<span style="color:red;">Non Refundable</span>'!!}<br>{!!!empty($pr->meal) && $pr->meal == 'yes'?'<span style="color:green;">Meal Included</span>':'Meal Not Included'!!}<br>{{!empty($pr->seats)?$pr->seats:'0'}} Seats Available</td>
          <td {{$pr->one_way_or_return == 1?'rowspan=2':''}}><span style="display:block;margin:10px 0;">7kg Handcarry</span>  {!! !empty($pr->luggage)?'<span style="color:white;background:#f58220;padding:5px;margin-top:5px;">'.$pr->luggage.'kg'.' Luggage </span>':''!!}</td>
          <td {{$pr->one_way_or_return == 1?'rowspan=2':''}} class="text-capitalize"><a
              href="{{url('agent/'.$pr->agent->slug)}}"
              style="color: #f58220;">{{!is_null($pr->agent)?str_limit(strtolower($pr->agent->business_name), 30):''}}</a> <br>
            @if(!empty($pr->agent->phone)) @php $phone = explode(',', $pr->agent->phone); $count = 0; @endphp @foreach($phone as
            $p) @php $count++; @endphp @if($count == 1) <a href="tel:{{$p}}" style="color: unset;"> <i
                class="fa fa-phone-volume"></i> {{$p}}</a> @endif @endforeach @endif
                
          </td>
        </tr>
        @if($pr->one_way_or_return == 1)
        <tr>
          <td>{{$pr->return_flight_number}} 
           @if(!empty($pr->extra_r_via))
              <a  href="javascript:;" data-toggle="modal" data-target="#myModal{{$pr->id}}" class="btn btn-primary btn-sm d-block mt-1 mb-1">Connection Time: {{ getTimeDiff($pr->return_arrival_time, $pr->extra_return_departure_time1) }}</a>
              {{$pr->extra_r_flight_code1}}
              @endif
          
          </td>
          <td>{{$pr->return_from}} <br> {{ date("H:i", strtotime($pr->return_departure_time)) }}</td>
        
          <td>{{$pr->return_to}} <br> {{ date("H:i", strtotime($pr->return_arrival_time)) }}</td>
          <td>{{ date("d M Y", strtotime($pr->in_bound_date))}}</td>
        </tr>
        @endif
    @endforeach

@else
    @foreach($flights as $pr)
    
    <!--<div class="box-hang-title">-->
    <!--  <h3 class="" style="padding: 7px 25px 5px 25px;">}</h3>-->
    <!--</div>-->
    
    
    
    <div class="row listings {{!empty($pr->extra_via)?'showDetail':''}}"
      style="{{!empty($pr->extra_via)?'cursor: pointer':''}}">
    
      <!-- 
                    {{!empty($pr->extra_via)?'background: #f58220;':''}} -->
      <div class="mobile-flight-box-header" style=" padding: 0">
    
        <div class="row">
          <div class="col-md-12" style="    background: #f58220; color: #fff;padding: 5px 0;">
            <a href="{{url('agent/'.$pr->agent->slug)}}" style="color:unset" target="_blank">
              <p class="{{!empty($pr->extra_via)?'text-white':''}} text-capitalize mb-0 text-center">
                <b>{{!is_null($pr->agent)?strtolower($pr->agent->business_name):''}} ({{$pr->agent->city->name}})</b></p>
            </a>
          </div>
          <div class="col-8 " style="padding: 5px 0 5px 25px;">
            <p class=" text-capitalize mb-0"> @if(!empty($pr->agent->phone)) @php $phone = explode(',', $pr->agent->phone);
              $count = 0; @endphp @foreach($phone as $p) @php $count++; @endphp @if($count == 1)<a href="tel:{{$p}}"
                style="color: unset;"> <i class="fa fa-phone-volume"></i> {{$p}} </a> @endif @endforeach @endif</p>
            <small class="mb-0"> {!!!empty($pr->refundable) && $pr->refundable == 'yes'?'Refundable':'<span style="color:red;">Non Refundable</span>'!!} | {!!!empty($pr->meal) && $pr->meal == 'yes'?'<span style="color:green;">Meal Included</span>':'Meal Not Included'!!}<br>{{!empty($pr->seats)?$pr->seats:'0'}} Seats Available | <span style="margin:10px 0;">7kg Handcarry</span>  <br> {!! !empty($pr->luggage)?'<span style="color:white;background:#f58220;padding:5px;">'.$pr->luggage.'kg'.' Luggage </span>':''!!}</small>
          </div>
          <div class="col-4 text-center pl-0" style="position: relative;padding: 5px 25px 5px 0px;">
    
            @if(!is_null($pr->airline) && !empty($pr->airline->img))
            <img src="{{url('storage/uploads/airline/'.$pr->airline->img)}}" class="img-responsive"
              style="width: 100%;height:75px; bottom: 5px;left: 0;right: 0;object-fit:contain">
            @else
            <img src="//placehold.it/150x150" style="height: 50px;    position: absolute;bottom: 5px;left: 0;right: 0;">
            @endif
            <span>Rs.{{$pr->cost_price}}</span>
           
          </div>
        </div>
      </div>
      <div class="dropdown-detail row">
        <div class="col-3 text-center">
          <span class="mobile-col-heading">Flight</span>
          {{$pr->flight_number}}
        </div>
        <div class=" col-3 text-center" style="padding: 0">
          <span class="mobile-col-heading">Date</span>
          <span class="text-success"> {{ date_format(date_create($pr->out_bound_date), 'd M Y') }}</span>
        </div>
        <div class=" col-3 text-center">
          <span class="mobile-col-heading">From</span>
          <strong>{{$pr->first_from}}</strong><br>
        </div>
        @if(!empty($pr->extra_via))
        <div class=" col-3 text-center">
          <span class="mobile-col-heading">To</span>
          <strong>{{$pr->extra_via}}</strong><br>
        </div>
        <div class=" col-3">
    
        </div>
        <div class=" col-3">
        </div>
        <div class=" col-3 text-center">
          <!--<span class="mobile-col-heading">Dep.</span>-->
          <strong>{{ date("H:i", strtotime($pr->one_way_departure_time)) }}</strong>
        </div>
        <div class=" col-3 text-center" style="padding: 0;">
          <!--<span class="mobile-col-heading">Arrival</span>-->
          {{ date("H:i", strtotime($pr->one_way_arrival_time)) }}
        </div>
        <!--    Stop Flight Detail -->
        <div class="clearfix"></div>
        <div class="col-12"></div>
        <div class=" col-3  text-center">
          {{$pr->extra_flight_code1}}
        </div>
        <div class="col-3 text-center" style="padding: 0">
          @if($pr->extra_trancend_date != "same" && !empty($pr->extra_via))
          <span class="fa fa-calendar"></span>
          {{ date('d M Y', strtotime($pr->out_bound_date." +1 day") )}}
          @else
          {{ date('d M Y', strtotime($pr->out_bound_date) )}}
          @endif
        </div>
        <div class="col-md-1 col-3 text-center">
          <strong>{{ $pr->extra_via}}</strong><br>
        </div>
        @endif
        <div class="col-md-1 col-3 text-center">
          {!! empty($pr->extra_via)?'<span class="mobile-col-heading">To</span>':'' !!}
          <strong>{{ $pr->first_to}}</strong><br>
        </div>
        <div class=" col-3 text-center">
          <!--<span class="mobile-col-heading">Seats</span>-->
          <!--<strong>{{$pr->seats}}</strong>-->
        </div>
        <div class=" col-3">
        </div>
        <div class="col-md-1 col-3 text-center">
          <!--{!! empty($pr->extra_via)?'<span class="mobile-col-heading">Dep.</span>':''!!}-->
          @if (!empty($pr->extra_via))
          <strong>{{ date("H:i", strtotime($pr->extra_one_way_departure_time1))}}</strong>
          @else
          <strong>{{ date("H:i", strtotime($pr->one_way_departure_time))}}</strong>
          @endif
        </div>
    
        <div class="col-md-1 col-3 text-center">
          <!--{!! empty($pr->extra_via)?'<span class="mobile-col-heading">Arrival</span>':''!!}-->
          @if (!empty($pr->extra_via))
          {{ date("H:i", strtotime($pr->extra_one_way_arrival_time1))}}
          @else
          {{ date("H:i", strtotime($pr->one_way_arrival_time))}}
          @endif
        </div>
      </div>
      @if ($pr->one_way_or_return == 1)
    
      <hr style="margin: 0 auto;border-bottom: 2px solid #0675b3;width: 79%;">
    
    
      <div class="dropdown-detail row">
        <div class=" col-3 text-center">
          <span class="mobile-col-heading">Flight</span>
          {{$pr->return_flight_number}}
        </div>
        <div class="col-3 text-center" style="padding: 0">
          <span class="mobile-col-heading">Date</span>
          <span class="fa fa-calendar"></span>
          {{ date('d M Y', strtotime($pr->in_bound_date) ) }}
        </div>
        <div class="col-md-1 col-3 text-center">
          <span class="mobile-col-heading">From</span>
          <strong>{{$pr->return_from}}</strong><br>
        </div>
        <!--        show if via retuen -->
        @if(!empty($pr->extra_r_via))
        <div class="col-md-1 col-3 text-center">
          <span class="mobile-col-heading">To</span>
          <strong>{{$pr->extra_r_via}}</strong><br>
        </div>
        <div class=" col-3">
        </div>
        <div class=" col-3">
        </div>
        <div class="col-md-1 col-3 text-center">
          <!--<span class="mobile-col-heading">Dep.</span>-->
          <strong>{{ date("H:i", strtotime($pr->return_departure_time)) }}</strong>
        </div>
    
        <div class="col-md-1 col-3 text-center">
          <!--<span class="mobile-col-heading">Arrival</span>-->
          {{ date("H:i", strtotime($pr->return_arrival_time)) }}
        </div>
        <!--        Stop Flight Detail -->
        <div class="clearfix"></div>
        <div class="col-12"></div>
        <div class="col-md-1 col-3 text-center">
          {{$pr->extra_r_flight_code1}}
        </div>
        <div class="col-md-3 text-center col-3 text-center" style="padding: 0">
          @if ($pr->extra_r_trancend_date != "same" && !empty($pr->extra_r_via))
          <span class="fa fa-calendar"></span>
          {{ date('d M Y', strtotime($pr->in_bound_date. " +1 day") ) }}
          @else
          <span class="fa fa-calendar"></span>
          {{ date('d M Y', strtotime($pr->in_bound_date) ) }}
          @endif
        </div>
        <div class="col-md-1 col-3 text-center">
          <strong>{{$pr->extra_r_via}}</strong><br>
        </div>
        @endif
        <div class="col-md-1 col-3 text-center">
          {!! empty($pr->extra_r_via)?'<span class="mobile-col-heading">To</span>':'' !!}
          <strong>{{ $pr->return_to}}</strong><br>
        </div>
        <div class=" col-3">
        </div>
        <div class=" col-3">
        </div>
        <div class="col-md-1 col-3 text-center">
          <!--{!! empty($pr->extra_r_via)?'<span class="mobile-col-heading">Dep.</span>':'' !!}-->
          @if (!empty($pr->extra_r_via))
          <strong>{{ date("H:i", strtotime($pr->extra_return_departure_time1))}}</strong>
          @else
          <strong>{{ date("H:i", strtotime($pr->return_departure_time))}}</strong>
          @endif
        </div>
        <div class="col-md-1 col-3 text-center">
          <!--{!! empty($pr->extra_r_via)?'<span class="mobile-col-heading">Arrival;</span>':'' !!}-->
          @if(!empty($pr->extra_via))
          {{ date("H:i", strtotime($pr->extra_return_arrival_time1))}}
          @else
          {{ date("H:i", strtotime($pr->return_arrival_time))}}
          @endif
        </div>
    
      </div>
      @endif
    </div>
    
    @endforeach
@endif