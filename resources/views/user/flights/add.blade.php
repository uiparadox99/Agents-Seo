@extends('layouts.master')
@section('content')

<div class="container">
   <div class="row ">
      <div class="col-md-3">
         @include('includes.user-sidebar')
      </div>
      <div class="col-md-9 agent-main-box" >
         <div class="content-box-agent">
            <form class="" id="airline-block-form" method="post" action="{{url('save-flight')}}">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail) && !request()->has('copy')?$detail->id:'' }}" />
               <h3 class="box-title text-center">@if(isset($detail) && !is_null($detail)) Edit @else Add @endif Umrah Ticket  </h3>
               <hr>
               <div class="form-group row">
                @if(isset($detail) && !is_null($detail))
                <div class="col-md-12">


                  @if($detail->one_way_or_return == 1)
                  <input type="hidden" name="one_way_or_return" value="1">
                  <h3 class="text-center">Return Flight</h3>
                  @else
                  <input type="hidden" name="one_way_or_return" value="0">
                  <h3 class="text-center">One Way Flight</h3>
                  @endif
                </div>
                @else
                <div class="col-md-4">
                  <div class="account-type">
                    <div style="margin-right: 19px;">
                      <input type="radio" name="one_way_or_return" id="one_way_trip" class="flight_type account-type-radio" {{isset($detail) && !is_null($detail) && $detail->one_way_or_return == 0 ?"checked":"" }}  value="0"/>

                      <label for="one_way_trip" class="ripple-effect-dark">One Way</label>
                    </div>
                    <div>
                      <input type="radio" name="one_way_or_return" id="return_travel" class="flight_type account-type-radio" {{isset($detail) && !is_null($detail) && $detail->one_way_or_return == 1 ?"checked":"" }} value="1" {{!isset($detail)?"checked":"" }}/>
                      <label for="return_travel" class="ripple-effect-dark">Return</label>
                    </div>


                  </div>
                </div>
                @endif

              </div>
               <div class="row">
                  <div class="col-md-4 col-6 form-group ">
                     <label>Airline</label>
                     <select id="airline" class=" form-control " data-validation="required" name="airline" >
                        <option value="">Select Airline </option>
                        @foreach($airlines as $a)
                        <option value="{{ $a->id}}" {{ isset($detail) && $detail->airline->id == $a->id ?"selected='selected'":""}}>{{ $a->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 col-6 form-group " >
                     <label >Adult Price</label>
                     <input type="text" class="form-control number-style"  data-validation="required"placeholder="Adult Price" name="cost_price" value="{{isset($detail) && !is_null($detail)?$detail->cost_price:'' }}"/>
                  </div>
                  <div class="col-md-2 form-group">
                       <label>Seats</label>
                       <input type="number" class="form-control" name="seats" placeholder="Seats" value="{{isset($detail)  && !is_null($detail)? $detail->seats:''}}">
                   </div>
                  <div class="col-md-2 form-group">
                       <label>Luggage</label>
                       <input type="text" class="form-control" name="luggage" placeholder="Luggage" value="{{isset($detail)  && !is_null($detail)? $detail->luggage:''}}">
                   </div>
               </div>
               <div class="row">
                  <div class="col-md-4 col-6 form-group">
                     <label>From</label>
                     <select id="from" class="form-control " data-validation="required" name="from" style="" >
                        <option value=""> Select </option>
                        @foreach($from as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->first_from == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group col-6 col-md-4">
                     <label >To</label>
                     <select id="to" class="form-control" data-validation="required" name="to" style="" >
                        <option value=""> Select </option>
                        @foreach($cities as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->first_to == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                    <div class="col-md-4 {{$detect->isMobile()?'form-group':''}}">
                     <label class=" red-color">Via Location</label>
                     <select id="extra_from" class="form-control " name="extra_via" style="" >
                        <option value=""> Select </option>
                        @foreach($via as $c)
                        <option value="{{$c->name}}" {{isset($detail)  && !is_null($detail) && $detail->extra_via == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 col-6 form-group">
                    @if(!$detect->isMobile())
                     <label ><span class="firstFlight firstflightNumber" style="color: #070c39;font-weight: 500"></span>&nbsp;</label>
                     @else
                     <label ><span class="firstFlight firstflightNumber" style="color: #070c39;font-weight: 500"></span> Flight Number</label>
                     @endif
                     <input type="text" class="form-control flightNumber  number-style" pattern="[a-zA-Z0-9\s]+" data-validation="required" maxlength="6" name="flight_number" value="{{ isset($detail)  && !is_null($detail) && isset($detail->flight_number)?$detail->flight_number:''}}" placeholder="Flight Number" />
                  </div>
                  <div class="col-md-4 col-6 form-group">
                    @if(!$detect->isMobile())
                     <label>&nbsp;</label>
                     @else
                     <label>Out Bound Date</label>
                     @endif
                     <input type="text" placeholder="DD-MMM-YYYY"  class="form-control  number-style" data-validation="required" id="out_bound_date" name="out_bound_date" value="{{ isset($detail)  && !is_null($detail) && !empty($detail->out_bound_date)? date('d-M-Y', strtotime($detail->out_bound_date)) :''}}"/>
                  </div>
                  <div class="col-md-2 col-6 form-group">
                     <label>Departure </label>
                     <input type="text" placeholder="HH:MM" class="form-control  number-style time-formate" data-validation="required" name="one_way_departure_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_departure_time)? date('H:i',strtotime($detail->one_way_departure_time)) : ''}}"/>
                  </div>
              
                  <div class="col-md-2 col-6 form-group">
                     <label><span class="firstArival"></span>  Arrival</label>
                     <input type="text"  placeholder="HH:MM"  class="form-control number-style time-formate" data-validation="required" name="one_way_arrival_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_arrival_time)? date('H:i',strtotime($detail->one_way_arrival_time)) : ''}}"/>
                  </div>
            
              </div>
              @if(isset($detail) && !empty($detail->extra_flight_code1))
              <div class="row via_fields">
              @else
              <div class="row via_fields" style="display: none;">
               @endif
                  <div class="col-md-4 col-6 via-first form-group">
                    @if(!$detect->isMobile())
                     <label class=" via-first red-color"><span class="viaflightnumber" style="color: #070c39;font-weight: 500"></span>&nbsp;</label>
                     @else
                     <label class=" via-first red-color"><span class="viaflightnumber" style="color: #070c39;font-weight: 500"></span>Via Flight Number</label>
                     @endif
                     <input type="text" class="form-control flightNumber number-style" pattern="[a-zA-Z0-9\s]+" data-validation="required" maxlength="6" name="extra_flight_code1" value="{{ isset($detail)  && !is_null($detail)?$detail->extra_flight_code1:''}}" placeholder="Flight Number"/>
                  </div>
                    <div class="col-md-4 col-6 via-first form-group">
                     <label class=" via-first red-color"><span class="secondFlight"></span> &nbsp;</label>
                     <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style dateInput" data-validation="required" id="extra_trancend_date" name="extra_trancend_date" value="{{ isset($detail)  && !is_null($detail) && !empty($detail->extra_trancend_date)? date('d-M-Y', strtotime($detail->extra_trancend_date)) :''}}"/>
                  </div>
                  <!--<div class="col-md-4 col-6 via-first form-group">-->
                  <!--   <label class=" via-first red-color"><span class="secondFlight"></span> &nbsp;</label>-->
                  <!--   <select class="form-control" name="extra_trancend_date" data-validation="required">-->
                  <!--   <option value="same" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "same")?"selected='selected'":''}}>Same Day</option>-->
                  <!--   <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>-->
                  <!--   </select>-->
                  <!--</div>-->
                   <div class="col-md-2 col-6 via-first form-group">
                     <label class="via-first"><span class="secondDeparture"></span> Departure</label>
                     <input type="text" placeholder="HH:MM" data-validation="required" class="form-control  number-style time-formate" name="extra_one_way_departure_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_departure_time1)? date('H:i',strtotime($detail->extra_one_way_departure_time1)) : ''}}"/>
                  </div>
                  <div class="col-md-2 col-6 form-group via-first">
                     <label class="via-first"><span class="secondArival"></span> Arrival </label>
                     <input type="text"  placeholder="HH:MM" data-validation="required" class="form-control  number-style time-formate" name="extra_one_way_arrival_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_arrival_time1)? date('H:i',strtotime($detail->extra_one_way_arrival_time1)) :''}}"/>
                  </div>
                  </div>
                  @if(isset($detail)  && !is_null($detail) && $detail->one_way_or_return == 1 || !isset($detail))
                  <div class="returnfields " >
                  @else
                  <div class="returnfields " style="display: none;">
                  @endif
                 <div class="row">
                  <div class="col-md-12">
                     <hr style="width: 50%;border: 2px solid #070c39;">
                    <h4 class="text-center">Return Details</h4>
                  </div>
                   <div class="col-md-8">
                       
                   </div>
                    <div class="col-md-4 form-group returnfields" style="{{isset($detail)  && !is_null($detail) && $detail->one_way_or_return == 1 || !isset($detail)?'':'display:none'}}">
                        <label>Return Luggage</label>
                        <input type="text" class="form-control" name="return_luggage" value="{{isset($detail)  && !is_null($detail)? $detail->return_luggage:''}}" placeholder="Luggage">
                   </div>
                  <div class="col-md-4 col-6 form-group">
                     <label>From</label>
                     <input type="text" name="return_from" class="return_from_custome form-control" value="{{isset($detail)  && !is_null($detail)?$detail->return_from:''}}">
                  </div>
                  <div class="form-group col-6 col-md-4">
                     <label>To</label>
                    <input type="text" name="return_to" class="return_to_custome form-control" value="{{isset($detail)  && !is_null($detail)?$detail->return_to:''}}">
                  </div>
                  <div class="col-md-4  form-group return-wrapper">
                     <label class="return-wrapper red-color">Via Location</label>
                     <select id="extra_r_from" class="form-control " name="extra_r_via" >
                        <option value=""> Select </option>
                        @foreach($via as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->extra_r_via == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-4 col-6 return-wrapper form-group">
                     <label class=" return-wrapper"><span class="returnFlight returnflightNumber" style="color: #070c39;font-weight: 500"></span> &nbsp;</label>
                     <input type="text" class="form-control flightNumber  number-style" pattern="[a-zA-Z0-9\s]+" data-validation="required"  maxlength="6" name="return_flight_number" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_flight_number)?$detail->return_flight_number:''}}" placeholder="Flight Number"/>
                  </div>
                  <div class="col-md-4 col-6 form-group return-wrapper">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style"  id="in_bound_date" name="in_bound_date" value="{{ isset($detail)  && !is_null($detail) && (!empty($detail->in_bound_date) && date('d-M-Y', strtotime($detail->in_bound_date)) != '01-Jan-1970')? date('d-M-Y', strtotime($detail->in_bound_date)) : ''}}"/>
                  </div>
                  <div class="col-md-2 col-6 form-group return-wrapper">
                     <label class=" return-wrapper"><span class="returnDeparture"></span> Departure</label>
                     <input type="text" placeholder="HH:MM" data-validation="required"   class="form-control time-formate number-style" name="return_departure_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_departure_time)? date('H:i',strtotime($detail->return_departure_time)) : ''}}"/>
                  </div>
                  <div class="col-md-2 col-6 form-group return-wrapper">
                     <label class="return-wrapper"><span class="retunArival"></span>  Arrival</label>
                     <input type="text" placeholder="HH:MM" data-validation="required" class="form-control time-formate number-style" name="return_arrival_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_arrival_time)? date('H:i',strtotime($detail->return_arrival_time)) : ''}}"/>
                  </div>
               </div>
               @if(isset($detail) && !empty($detail->extra_r_flight_code1))
               <div class="row return_via_fields">
                @else
                <div class="row return_via_fields" style="display: none;">
                 @endif
                  <div class="col-md-4 col-6 form-group via-second">
                     <label class="via-second red-color"><span class="secondReturnFlight returnviaflightnumber" style="color: #070c39;font-weight: 500"></span>&nbsp;</label>
                     <input type="text" class="form-control flightNumber number-style" pattern="[a-zA-Z0-9\s]+" data-validation="required" maxlength="6" name="extra_r_flight_code1" value="{{ isset($detail)  && !is_null($detail)?$detail->extra_r_flight_code1:''}}" placeholder="Flight Number"/>
                  </div>
                   <div class="col-md-4 col-6 via-second form-group">
                        <label>&nbsp;</label>
                     <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style dateInput" data-validation="required" id="extra_r_trancend_date" name="extra_r_trancend_date" value="{{ isset($detail)  && !is_null($detail) && !empty($detail->extra_r_trancend_date)? date('d-M-Y', strtotime($detail->extra_r_trancend_date)) :''}}"/>
                  </div>
                  <!--<div class="col-md-4 col-6 via-second">-->
                  <!--   <label>&nbsp;</label>-->
                  <!--   <select class="form-control" name="extra_r_trancend_date" data-validation="required">-->
                  <!--   <option value="same" {{ isset($detail)  && !is_null($detail) && $detail->extra_r_trancend_date == "same"?"selected='selected'":''}}>Same Day</option>-->
                  <!--   <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_r_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>-->
                  <!--   </select>-->
                  <!--</div>-->
                  <div class="col-md-2 col-6 form-group via-second">
                     <label class="via-second"><span class="secondReturnDeparture"></span> Departure</label>
                     <input type="text" placeholder="HH:MM"  data-validation="required" class="form-control  number-style time-formate" name="extra_return_departure_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_departure_time1)? date('H:i',strtotime($detail->extra_return_departure_time1))  :''}}"/>
                  </div>
                  <div class="col-md-2 col-6 form-group via-second">
                     <label class="via-second"><span class="secondReturnArival"></span> Arrival</label>
                     <input type="text" placeholder="HH:MM"  data-validation="required" class="form-control  number-style time-formate" name="extra_return_arrival_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_arrival_time1)? date('H:i',strtotime($detail->extra_return_arrival_time1)) :''}}"/>
                  </div>
                  </div>
               </div>
                 <div class="row">
                 
                 
                     <div class="col-md-4 form-group">
                       <label>Meal included</label>
                        <select name="meal" class="form-control">
                             <option value="no" {{ isset($detail)  && !is_null($detail) && $detail->meal == 'no'?'selected':''}}>No</option>
                             <option value="yes" {{ isset($detail)  && !is_null($detail) && $detail->meal == 'yes'?'selected':''}}>Yes</option>
                       </select>
                   </div>
                    <div class="col-md-4 form-group">
                       <label>Refundable</label>
                        <select name="refundable" class="form-control">
                             <option value="no" {{ isset($detail)  && !is_null($detail) && $detail->refundable == 'no'?'selected':''}}>No</option>
                             <option value="yes" {{ isset($detail)  && !is_null($detail) && $detail->refundable == 'yes'?'selected':''}}>Yes</option>
                       </select>
                   </div>
                   
               </div>
                  <div class="form-group">
                       <label>Remarks</label>
                        <textarea name="remarks" class="form-control">{{ isset($detail)  && !is_null($detail)?$detail->remarks:''}}</textarea>
                   </div>
                      <button type="submit" name="save"  class="btn btn-primary">Save Ticket</button> <input type="reset" name="" class="btn btn-default" value="Reset">
               </div>
          
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
@push('script')
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
@if(isset($detail)  && !is_null($detail))
<script type="text/javascript">
    $(document).ready(function(){
      $('#out_bound_date').datepicker( {
               format: "d-M-yyyy", 
               autoclose: true,
               endDate: $("#in_bound_date").val(),
           }).on('changeDate', function(selected){
           $('#in_bound_date').datepicker('setStartDate', $("#out_bound_date").val());
       }); 
   
       $('#in_bound_date').datepicker({
           format: "d-M-yyyy", 
           autoclose: true,
           startDate: $("#out_bound_date").val(),
       }).on('changeDate', function(selected){
           $('#out_bound_date').datepicker('setEndDate', $("#in_bound_date").val());
       }); 
    });
</script>
@else
<script type="text/javascript">
    $(document).ready(function(){
      $('#out_bound_date').datepicker( {
               format: "d-M-yyyy", 
               autoclose: true,
               startDate: new Date(),
               endDate: $("#in_bound_date").val(),
           }).datepicker('setDate',new Date()).on('changeDate', function(selected){
           $('#in_bound_date').datepicker('setStartDate', $("#out_bound_date").val());
       }); 
   
       $('#in_bound_date').datepicker({
           format: "d-M-yyyy", 
           autoclose: true,
           startDate: $("#out_bound_date").val(),
       }).datepicker('setDate',new Date(Date.now() + 86400000)).on('changeDate', function(selected){
           $('#out_bound_date').datepicker('setEndDate', $("#in_bound_date").val());
       }); 
    });
</script>
@endif
<script>
   $(document).ready(function(){
//     $('.flightNumber').keypress(function(event){
//     //get envent value       
//     var inputValue = event.which;
//     // check whitespaces only.
//     if(inputValue == 32){
//         return true;    
//     }
//      // check number only.
//     if(inputValue == 48 || inputValue == 49 || inputValue == 50 || inputValue == 51 || inputValue == 52 || inputValue == 53 ||  inputValue ==  54 ||  inputValue == 55 || inputValue == 56 || inputValue == 57){
//         return true;
//     }
//     // check special char.
//     if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) { 
//         event.preventDefault(); 
//     }
// });
      $(".time-formate").inputmask({"mask": "99:99"});
      
       $('.dateInput').datepicker( {
               format: "d-M-yyyy", 
               autoclose: true,
               startDate: new Date(),
           });
 
       
       // $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
   
       // $('[name="status"]').click(function(){
       //     if($(this).val() == "time_limit"){
       //         $(".status-date-time").show();
       //     }else{
       //         $(".status-date-time").hide();
       //     }
       // });
   
       // $(".form-validation").validationEngine();
      $("input[type='radio']").click(function(){
            var radioValue = $("input[name='one_way_or_return']:checked").val();
            if(radioValue == 1){
                $('.returnfields').show('slow');
            }else{
               $('.returnfields').hide('slow');
            }
        });
       $('#from, #to, #extra_from, #extra_r_from').on('change',
           function () {
               if ($('#from').val() == $('#to').val()) {
                   $(this).val("");
                    toastr["error"]('Departure and destination cities cannot be same');
               }
   
               if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_from').val() == $('#to').val() || $('#extra_from').val() == $('#from').val())) {
                   $(this).val("");
                   toastr["error"]('Via location connot be same with departure and destination');
                   
               }
   
               if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_r_from').val() == $('#to').val() || $('#extra_r_from').val() == $('#from').val())) {
                   $(this).val("");
                   toastr["error"]('Via location connot be same with departure and destination');
                  
               }
           }
       );
       $("#to").change(function(){
        var from =  $('#from option:selected').val();
        var to = $('#to option:selected').val();
        var retrunfrom = $('.return_from_custome').val(to);
        var via = $("#extra_from option:selected").val();
        if(via.length){
           $('.firstflightNumber').text(from+' To '+ via);
        }else{

           $('.firstflightNumber').text(from+' To '+ to);
           $('.returnflightNumber').text(to+' To '+ from);
        }
     });
       $("#from").change(function(){
        var from =  $('#from option:selected').val();
        var via = $("#extra_from option:selected").val();
         var to = $('#to option:selected').val();
            var retrunto = $('.return_to_custome').val(from);
        if(via.length){
           $('.firstflightNumber').text(from+' To '+ via);
        }else{

           $('.firstflightNumber').text(from+' To '+ to);
           $('.returnflightNumber').text(to+' To '+ from);
        }
     });
       $("#extra_from").change(function(){
        var from =  $('#from option:selected').val();
            var to = $('#to option:selected').val();
        var via = $("#extra_from option:selected").val();
         $("#extra_r_from").val(via);
        if(via.length){
          $('.returnflightNumber').text(to+' To '+ via);
           $('.returnviaflightnumber').text(via+' To '+from);
           $('.return_via_fields').show('slow');
           $('.firstflightNumber').text(from+' To '+ via);
           $('.viaflightnumber').text(via+' To '+to);
        }else{

           $('.firstflightNumber').text(from+' To '+ to);
           $('.return_via_fields').hide('slow');
           
        }
     });
        $("#extra_r_from").change(function(){
        var from =  $('#from option:selected').val();
        var to = $('#to option:selected').val();
        var via = $("#extra_r_from option:selected").val();
        if(via.length){
           $('.returnflightNumber').text(to+' To '+ via);
           $('.returnviaflightnumber').text(via+' To '+from);
        }else{

           $('.returnflightNumber').text(to+' To '+ from);
        }
     });
        $("#extra_from").change(function(){
           var val =  $("#extra_from option:selected").val();
           if (val.length) {
            $('.via_fields').show('slow');
           }else{
              $('.via_fields').hide('slow');
           }
       });
          $("#extra_r_from").change(function(){
           var val =  $("#extra_r_from option:selected").val();
           if (val.length) {
            $('.return_via_fields').show('slow');
           }else{
              $('.return_via_fields').hide('slow');
           }
       });
   
      
  
   });
</script>
@endpush