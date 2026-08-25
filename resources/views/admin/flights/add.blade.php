@extends('admin.layout.master')

@section('content')

<div class="content-wrapper">
      <section class="content-header">
        <h1>
            Add / Edit Fight
        </h1>

    </section>
   <section class="content">
  
                <div class="box">
                    <div class="box-body row">
                   
        	  	     <form class="col-md-8 col-md-offset-2" id="airline-block-form" method="post" action="{{url('admin/save-flight')}}">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:'' }}" />
            
               <div class="form-group row">
                <div class="col-md-12">
                  <!--          <label class="control-label">Flight Type</label> -->
                  @if(isset($detail) && !is_null($detail))
               @if($detail->one_way_or_return == 1)
                  <input type="hidden" name="one_way_or_return" value="1">
                  <h3 class="text-center">Return Flight</h3>
                  @else
                   <input type="hidden" name="one_way_or_return" value="0">
                    <h3 class="text-center">One Way Flight</h3>
                  @endif
                  @else
                  <div class="account-type">
                    <div style="margin-right: 19px;">
                      <input type="radio" name="one_way_or_return" id="one_way_trip" class="flight_type account-type-radio" {{isset($detail) && !is_null($detail) && $detail->one_way_or_return == 0 ?"checked":"" }} {{!isset($detail)?"checked":"" }} value="0"/>

                      <label for="one_way_trip" class="ripple-effect-dark">One Way</label>
                    </div>
                    <div>
                      <input type="radio" name="one_way_or_return" id="return_travel" class="flight_type account-type-radio" {{isset($detail) && !is_null($detail) && $detail->one_way_or_return == 1 ?"checked":"" }} value="1"/>
                      <label for="return_travel" class="ripple-effect-dark">Return</label>
                    </div>


                  </div>
                  @endif
                </div>

              </div>
               <!-- /.form-group -->
               <div class="form-group row">
               
                <div class="col-md-12 form-group">
                  <label>Agents</label>
                  <select name="agents" class="form-control select2" data-validation="required">
                    <option value="">Select</option>
                    @foreach($agents as $a)
                    <option value="{{$a->id}}" {{isset($detail) && !is_null($detail) && $detail->agents_id == $a->id?'selected':''}}>{{$a->business_name}}</option>
                    @endforeach
                  </select>
                </div>
           
                  <div class="col-md-6">
                     <label>Airline</label>
                     <select id="airline" class=" form-control " data-validation="required" name="airline" >
                        <option value="">Select Airline </option>
                        @foreach($airlines as $a)
                        <option value="{{ $a->id}}" {{ isset($detail) && $detail->airline->id == $a->id ?"selected='selected'":""}}>{{ $a->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <!-- <label class="col-md-2 control-label" >Ticket Price</label> -->
                  <div class="col-md-6" >
                     <label >Adult Price</label>
                     <input type="text" class="form-control number-style"  data-validation="required"placeholder="Adult Price" name="cost_price" value="{{isset($detail) && !is_null($detail)?$detail->cost_price:'' }}"/>
                  </div>
                 <!--  <div class="col-md-3" >
                     <label>Child Price</label>
                     <input type="text" class="form-control  number-style" data-validation="required" placeholder="Child Price" name="child_price" value="{{isset($detail) && !is_null($detail)?$detail->child_price:'' }}"/>
                  </div>
                  <div class="col-md-3" >
                     <label>Infant Price</label>
                     <input type="text" class="form-control  number-style" data-validation="required" placeholder="Infant Price" name="infant_price" value="{{isset($detail) && !is_null($detail)?$detail->infant_price:'' }}"/>
                  </div> -->
               </div>
               <!-- /.form-group -->
               <div class="row">
                  <div class="col-md-6 form-group">
                     <label>From</label>
                     <select id="from" class="form-control " data-validation="required" name="from" style="" >
                        <option value=""> Select </option>
                        @foreach($cities as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->first_from == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label >To</label>
                     <select id="to" class="form-control" data-validation="required" name="to" style="" >
                        <option value=""> Select </option>
                        @foreach($cities as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->first_to == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-6 form-group">
                     <label ><span class="firstFlight"></span> Flight Number</label>
                     <input type="text" class="form-control flightNumber  number-style" data-validation="required" tabindex="1" maxlength="6" name="flight_number" value="{{ isset($detail)  && !is_null($detail) && isset($detail->flight_number)?$detail->flight_number:''}}"/>
                  </div>
                  <div class="col-md-6 form-group">
                     <label>Out Bound Date</label>
                     <input type="text" placeholder="DD-MMM-YYYY" tabindex="2" class="form-control  number-style" data-validation="required" id="out_bound_date" name="out_bound_date" value="{{ isset($detail)  && !is_null($detail) && !empty($detail->out_bound_date)? date('d-M-Y', strtotime($detail->out_bound_date)) :''}}"/>
                  </div>
                  <div class="col-md-3 form-group">
                     <label>Departure Time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" tabindex="3" class="form-control  number-style" data-validation="required" name="one_way_departure_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_departure_time)? date('H',strtotime($detail->one_way_departure_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" tabindex="4" class="form-control  number-style" data-validation="required" name="one_way_departure_m" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_departure_time)? date('i',strtotime($detail->one_way_departure_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group">
                     <label><span class="firstArival"></span>  Arrival Time</label>
                     <input type="text" max="23" maxlength="2" placeholder="HH" tabindex="5" class="form-control number-style" data-validation="required" name="one_way_arrival_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_arrival_time)? date('H',strtotime($detail->one_way_arrival_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3"> 
                     <label>&nbsp;</label>    
                     <input type="text" max="59" maxlength="2" placeholder="MM" tabindex="6" class="form-control  number-style" data-validation="required" name="one_way_arrival_m" value="{{ isset($detail)  && !is_null($detail) && isset($detail->one_way_arrival_time)? date('i',strtotime($detail->one_way_arrival_time)) : ''}}"/>
                  </div>
                  <div class="col-md-12">
                     <p class="text-danger">Note: <b>Leave via fields if its direct flight</b></p>
                  </div>
                  <div class="col-md-6">
                     <label class=" red-color">Via Location</label>
                     <select id="extra_from" class="form-control " name="extra_via" style="" >
                        <option value=""> Select </option>
                        @foreach($cities as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->extra_via == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-6 via-first form-group">
                     <label class=" via-first red-color"><span class="secondFlight"></span>Via Flight Number</label>
                     <input type="text" class="form-control  number-style" name="extra_flight_code1" value="{{ isset($detail)  && !is_null($detail)?$detail->extra_flight_code1:''}}"/>
                  </div>
                  <div class="col-md-3 form-group via-first">
                     <label class="via-first"><span class="secondArival"></span> Via Arrival Time</label>
                     <input type="text" max="23" maxlength="2" placeholder="HH" class="form-control  number-style" name="extra_one_way_arrival_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_arrival_time1)? date('H',strtotime($detail->extra_one_way_arrival_time1)) :''}}"/>
                  </div>
                  <div class="col-md-3 via-first form-group">
                     <label>&nbsp;</label>    
                     <input type="text" max="59" maxlength="2" placeholder="MM" class="form-control  number-style" name="extra_one_way_arrival_m1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_arrival_time1)? date('i',strtotime($detail->extra_one_way_arrival_time1)): ''}}"/>
                  </div>
                  <div class="col-md-6 via-first form-group">
                     <label class=" via-first red-color"><span class="secondFlight"></span>Via Departure Date</label>
                     <select class="form-control" name="extra_trancend_date">
                     <option value="same" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "same")?"selected='selected'":''}}>Same Day</option>
                     <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>
                     </select>
                  </div>
                  <div class="col-md-3 via-first form-group">
                     <label class="via-first"><span class="secondDeparture"></span> Via Departure Time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" class="form-control  number-style" name="extra_one_way_departure_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_departure_time1)? date('H',strtotime($detail->extra_one_way_departure_time1)) : ''}}"/>
                  </div>
                  <div class="col-md-3 via-first form-group">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" class="form-control  number-style" name="extra_one_way_departure_m1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_one_way_departure_time1)? date('i',strtotime($detail->extra_one_way_departure_time1)) : ''}}"/>
                  </div>
                  <div class="col-md-12">
                     <textarea name="status_remarks" cols="30" rows="4" class="form-control" placeholder="Remarks">{{isset($detail)  && !is_null($detail) && isset($detail->status_remarks)?$detail->status_remarks:""}}</textarea>
                  </div>
                  </div>
                  @if(isset($detail)  && !is_null($detail) && $detail->one_way_or_return == 1)
                  <div class="returnfields row" >
                  @else
                  <div class="returnfields row" style="display: none;">
                  @endif
                 
                  <div class="col-md-12">
                     <hr>
                     <h3 class="text-center">Return Detail</h3>
                     <hr>
                  </div>
                  <div class="col-md-6 return-wrapper form-group">
                     <label class=" return-wrapper"><span class="returnFlight"></span> Flight Number</label>
                     <input type="text" class="form-control flightNumber  number-style" tabindex="7" maxlength="6" name="return_flight_number" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_flight_number)?$detail->return_flight_number:''}}"/>
                  </div>
                  <div class="col-md-6 form-group return-wrapper">
                     <label>Return Date</label>
                     <input type="text" placeholder="DD-MMM-YYYY" class="form-control  number-style" tabindex="8" id="in_bound_date" name="in_bound_date" value="{{ isset($detail)  && !is_null($detail) && (!empty($detail->in_bound_date) && date('d-M-Y', strtotime($detail->in_bound_date)) != '01-Jan-1970')? date('d-M-Y', strtotime($detail->in_bound_date)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group return-wrapper">
                     <label class=" return-wrapper"><span class="returnDeparture"></span> Departure Time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" tabindex="9" class="form-control  number-style" name="return_departure_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_departure_time)? date('H',strtotime($detail->return_departure_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group return-wrapper">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" tabindex="10" class="form-control  number-style" name="return_departure_m" value="{{ isset($detail)  && !is_null($detail) &&  isset($detail->return_departure_time)? date('i',strtotime($detail->return_departure_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group return-wrapper">
                     <label class="return-wrapper"><span class="retunArival"></span>  Arrival Time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" tabindex="11" class="form-control  number-style" name="return_arrival_h" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_arrival_time)? date('H',strtotime($detail->return_arrival_time)) : ''}}"/>
                  </div>
                  <div class="col-md-3 form-group return-wrapper">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" tabindex="12" class="form-control  number-style" name="return_arrival_m" value="{{ isset($detail)  && !is_null($detail) && isset($detail->return_arrival_time)? date('i',strtotime($detail->return_arrival_time)) :'' }}"/>
                  </div>
                  <div class="col-md-6 form-group return-wrapper">
                     <label class="return-wrapper red-color">Extra Via Location</label>
                     <select id="extra_r_from" class="form-control " name="extra_r_via" >
                        <option value=""> Select </option>
                        @foreach($cities as $c)
                        <option value="{{$c->name}}"{{isset($detail)  && !is_null($detail) && $detail->extra_r_via == $c->name?"selected='selected'":""}}>{{$c->name}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-6 form-group via-second">
                     <label class="via-second red-color"><span class="secondReturnFlight"></span> Flight Number</label>
                     <input type="text" class="form-control number-style" name="extra_r_flight_code1" value="{{ isset($detail)  && !is_null($detail)?$detail->extra_r_flight_code1:''}}"/>
                  </div>
                  <div class="col-md-6 via-second">
                     <label>Extra Departure Date</label>
                     <select class="form-control" name="extra_r_trancend_date">
                     <option value="same" {{ isset($detail)  && !is_null($detail) && $detail->extra_r_trancend_date == "same"?"selected='selected'":''}}>Same Day</option>
                     <option value="next" {{ isset($detail)  && !is_null($detail) && ($detail->extra_r_trancend_date == "next")?"selected='selected'":''}}>Next Day</option>
                     </select>
                  </div>
                  <div class="col-md-3 form-group via-second">
                     <label class="via-second"><span class="secondReturnDeparture"></span> Departure time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" class="form-control  number-style" name="extra_return_departure_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_departure_time1)? date('H',strtotime($detail->extra_return_departure_time1))  :''}}"/>
                  </div>
                  <div class="col-md-3 via-second">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" class="form-control  number-style" name="extra_return_departure_m1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_departure_time1)? date('i',strtotime($detail->extra_return_departure_time1)) :''}}"/>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3 form-group via-second">
                     <label class="via-second"><span class="secondReturnArival"></span> Arrival Time</label>
                     <input type="text" placeholder="HH" max="23" maxlength="2" class="form-control  number-style" name="extra_return_arrival_h1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_arrival_time1)? date('H',strtotime($detail->extra_return_arrival_time1)) :''}}"/>
                  </div>
                  <div class="col-md-3 form-group via-second">
                     <label>&nbsp;</label>
                     <input type="text" placeholder="MM" max="59" maxlength="2" class="form-control  number-style" name="extra_return_arrival_m1" value="{{ isset($detail)  && !is_null($detail) && isset($detail->extra_return_arrival_time1)? date('i',strtotime($detail->extra_return_arrival_time1)) :''}}"/>
                  </div>

                  </div>
                  <!-- <div class="col-md-6">
                     <h4 class="returnFlightTextJS"></h4>
                     </div> -->
             
               <hr>
               <div class="form-group">
                  <button type="submit" name="save"  class="btn btn-success btn-block">Save</button>
               </div>
               <!-- /.form-group -->
            </form>
</div>
  </div>

</section>
</div>
@endsection
@push('script')
<script>
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
       }).on('changeDate', function(selected){
           $('#out_bound_date').datepicker('setEndDate', $("#in_bound_date").val());
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
                   alert("Departure and destination cities cannot be same");
               }
   
               if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_from').val() == $('#to').val() || $('#extra_from').val() == $('#from').val())) {
                   $(this).val("");
                   alert("Via location connot be same with departure and destination");
               }
   
               if ($('#to').val() != "" && $('#from').val() != "" && ($('#extra_r_from').val() == $('#to').val() || $('#extra_r_from').val() == $('#from').val())) {
                   $(this).val("");
                   alert("Via location connot be same with departure and destination");
               }
           }
       );
   
       // $(".flightNumber").change(function(){
       //     $(this).val($(this).val().toUpperCase());
       // });
   
       // $("#extra_r_from").on("change", function(){
       //     if($(this).val().length){
       //         // showExtraDetails();
       //         // $(".extra-details-trigger").trigger("click");
       //         $(".via-second").removeAttr("style");
       //     }else{
       //         $(".via-second").attr("style", "opacity:0");
       //     }
       // });
   
       // $("#extra_from").on("change", function(){
       //     if($(this).val().length){
       //         // showExtraDetails();
       //         // $(".extra-details-trigger").trigger("click");
       //         $(".via-first").removeAttr("style");
       //     }else{
       //         $(".via-first").attr("style", "opacity:0");
       //     }
       // });
   
       // $(".via-second, .via-first").attr("style", "opacity:0");
   
       // if($("select[name=extra_via] option:selected").val() || $("select[name=extra_r_via] option:selected").val()){
       //     showExtraDetails();
       //     $(".via-first, .via-second").removeAttr("style");
       // }
   
   
       // showFlightText();
   
       // $(".extra-details-trigger").click(function(){
       //     if(("#extra_from").val() != ""){
       //         showExtraDetails(this, "show");
       //     }else{
       //         showExtraDetails(this);
       //     }
       // });
   
       // $(".flight_type").click(function(){
           
       //     showFlightText();
   
       //     if($(this).val() == '1'){
   
       //         $(".return-wrapper:not(.extra-details)").show();
       //         if($(".extra-details-trigger").hasClass("showExtraDetails")){
       //             $(".extra-details").show();
       //         }
       //         $(".via-second, .via-first").removeAttr("style");;
       //     }else{
       //         $(".return-wrapper").hide();
       //         $(".via-second, .via-first").attr("style", "opacity:0");
       //     }
       // });
   
       // if($(".flight_type:checked").val() == '1'){
   
       //     $(".return-wrapper:not(.extra-details)").show();
       //     if($(".extra-details-trigger").hasClass("showExtraDetails")){
       //         $(".extra-details").show();
       //     }
       // }
   
       
   
       //  <?php if (!empty($id)): ?>
       //     console.log("ruahsjkasbdk");
       //     $('#out_bound_date').datepicker("setDate", '{{ isset($detail)  && !is_null($detail) && !empty($detail->out_bound_date)?date("d-M-Y", strtotime($detail->out_bound_date)):''}}') ;
       // <?php endif; ?>
   
    

   
   // function showExtraDetails(e, hideShow = ""){
   //      showFlightText();
   //      if(hideShow == "show"){
   //         $(".extra-details").hide();
   //         $(".hide-on-extra-js").show();
   //         $(".hide-on-extra-js input").each(function(i, v){
   //             $(v).prop("disabled", false);
   //         });
   //         $(".disable-fields input").each(function(i, v){
   //             $(v).prop("disabled", true);
   //         });
   //      }else{
   //         if($(".flight_type:checked").val() == '1')
   //         {
   //             $(".extra-details").show();
   //         }else{
   //             $(".extra-details:not(.return-wrapper)").show();
   //         }
   //         $(".hide-on-extra-js").hide();
   //         $(".hide-on-extra-js input").each(function(i, v){
   //             $(v).prop("disabled", true);
   //         });
   //         $(".disable-fields input").each(function(i, v){
   //             $(v).prop("disabled", false);
   //         });
   //      }
   //     // if($(e).hasClass("showExtraDetails")){
   //     //     $(e).text("Show Extra Details").removeClass("showExtraDetails");
   //     //     $(".extra-details").hide();
   //     //     $(".hide-on-extra-js").show();
   //     //     $(".hide-on-extra-js input").each(function(i, v){
   //     //         $(v).prop("disabled", false);
   //     //     });
   //     //     $(".disable-fields input").each(function(i, v){
   //     //         $(v).prop("disabled", true);
   //     //     });
   //     // }else{
   //     //     $(e).text("Hide Extra Details").addClass("showExtraDetails");
   //     //     if($(".flight_type:checked").val() == '1')
   //     //     {
   //     //         $(".extra-details").show();
   //     //     }else{
   //     //         $(".extra-details:not(.return-wrapper)").show();
   //     //     }
   //     //     $(".hide-on-extra-js").hide();
   //     //     $(".hide-on-extra-js input").each(function(i, v){
   //     //         $(v).prop("disabled", true);
   //     //     });
   //     //     $(".disable-fields input").each(function(i, v){
   //     //         $(v).prop("disabled", false);
   //     //     });
   //     // }
   // }
   
   // function showFlightText(){
   //     var from = $("select[name=from] option:selected").val();
   //     var to = $("select[name=to] option:selected").val();
   //     var directVia = $("select[name=extra_via] option:selected").val();
   //     var returnVia = $("select[name=extra_r_via] option:selected").val();
   
   
   //     if(directVia.length > 0){
   //         var fromTo = from+" to "+directVia;
   //         var viaFromTo = directVia+" to "+to;
   //     }else{
   //         var fromTo = from+" to "+to;
   //         var viaFromTo = to+" to "+from;
   //     }
   
   //     if(returnVia.length > 0){
   //         var returnFromTo = to+" to "+returnVia;
   //         var returnViaFromTo = returnVia+" to "+from;
   //     }else{
   //         var returnFromTo = to+" to "+from;
   //         var returnViaFromTo = to+" to "+from;
   //     }
   
   //     var textReturn = "";
   //     if(from.length > 0 && to.length > 0){
   //         textReturn = "Return Flight: " + to+" &#8594; "+from;
   //     }
   
   //     // flight with sectors name
   //     $(".firstFlight").text(fromTo);
   //     $(".returnFlight").text(returnFromTo);
   
   //     // direct detail show
   //     $(".firstDeparture").text(from);
   //     if(directVia.length > 0){
   //         $(".firstArival").text(directVia);
   //     }else{
   //         $(".firstArival").text(to);
   //     }
   
   //     // return detail show
   //     $(".returnDeparture").text(to);
   //     if(returnVia.length > 0){
   //         $(".retunArival").text(returnVia);
   //     }else{
   //         $(".retunArival").text(from);
   //     }
   
   
   //     // direct side extra detail
   //     $(".secondFlight").text(viaFromTo);
   //     $(".secondDeparture").text(directVia);
   //     $(".secondArival").text(to);
   
   
   //     // return side extra detail
   //     $(".secondReturnFlight").text(returnViaFromTo);
   //     $(".secondReturnDeparture").text(returnVia);
   //     $(".secondReturnArival").text(from);
   
   
   //     // show text when change flight type from one to two 
   //     if($(".flight_type:checked").val() == '1')
   //     {
   //         $(".returnFlightTextJS").html(textReturn);
   //     }else{
   //         $(".returnFlightTextJS").html("");
   //     }
   // }
   });
</script>
@endpush