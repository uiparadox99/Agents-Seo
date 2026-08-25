
@if(!$detect->isMobile())

                      @foreach($hotels as $h)
                      <tr>

                        <td class="text-capitalize">
                         {{$h->hotel}}
                         <br>
                         {{$h->hotelcity}} <span style="color: #f58220">({{is_numeric($h->type)?$h->type." Star":$h->type}})</span>
                       </td>
                       <td >SAR {{$h->double}}</td>
                       <td >SAR {{$h->tripple}}</td>
                       <td >SAR {{$h->quad}}</td>
                       <td >{{date('d M Y',strtotime($h->price_start))}} - {{date('d M Y',strtotime($h->price_end))}} <br> <span class="text-capitalize" style="color: {{ $h->meal_type == 'breakfast'?'green':''  }}">{{$h->meal_type}}</span></td>
                      </td>
                  <!--     <td class="text-capitalize">{{$h->agent_name}}</td>
                    <td class="text-capitalize">{{$h->agent_contact}}</td> -->

                    <td class="text-capitalize"><a href="{{url('agent/'.$h->agent->slug)}}" style="color: #f58220;">{{!is_null($h->agent)?strtolower($h->agent->business_name):''}}</a> <br>  @if(!empty($h->agent->phone))   @php $phone = explode(',', $h->agent->phone);  $count = 0;  @endphp   @foreach($phone as $p)  @php $count++; @endphp @if($count == 1) <a href="tel:{{$p}}" style="color: unset;">  <i class="fa fa-phone-volume"></i>     {{$p}}</a>  @endif  @endforeach   @endif </td>
             
                  </tr>
                  @endforeach
            
              @else
              @foreach($hotels as $h)
              <table class="table table-striped table-bordered" style="margin-bottom: 10px;border: 2px solid #f58220;">


                <tr>
                   <th width="30%">Hotel in <br> <span style="color: #f58220; font-weight: normal;">{{$h->hotelcity}}</span> </th>
                 <td>  <span style="color: #f58220; font-weight: bolder;">{{$h->hotel}}</span> <span >({{is_numeric($h->type)?$h->type." Star":$h->type}})</span></td>
               </tr>
               <tr>
                    <th>Meal Type</th>
                      <td class="text-capitalize">  
                        @if($h->meal_type == 'room only')
                         {{$h->meal_type}}
                         @else
                         <span class="text-success">{{$h->meal_type}}</span>
                         @endif
                      </td>

                </tr>
              <tr>
                <td colspan="2" style="padding: 0">
                    <table width="100%" class="hotel-rate">
                        <tr>
                            <th>Double</th>
                             <th>Tripple</th>
                             <th>Quad</th>
                        </tr>
                        <tr>
                            <td >SAR {{$h->double}}</td>
                           <td >SAR {{$h->tripple}}</td>
                           <td >SAR {{$h->quad}}</td>
                         </tr>
                    </table>
                </td>
                 
             </tr>
        
            <tr>
             <th>Agent</th>
             <td class="text-capitalize"><a href="{{url('agent/'.$h->agent->slug)}}" style="color: #f58220;">{{!is_null($h->agent)?strtolower($h->agent->business_name):''}}</a> <br>  @if(!empty($h->agent->phone))   @php $phone = explode(',', $h->agent->phone);  $count = 0;  @endphp   @foreach($phone as $p)  @php $count++; @endphp @if($count == 1) <a href="tel:{{$p}}" style="color: unset;">  <i class="fa fa-phone-volume"></i>     {{$p}}</a>  @endif  @endforeach   @endif</td>
           </tr>
       


         </table>
         @endforeach
         @endif
