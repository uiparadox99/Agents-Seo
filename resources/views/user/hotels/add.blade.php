@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-3">
            @include('includes.user-sidebar')
        </div>
        <div class="col-md-9 agent-main-box">
            <form method="post" class="has-callback-validations content-box-agent" action="{{ route('user.save-umrah-hotel') }}"
                enctype="multipart/form-data" id="myModal">
                @csrf

                <input type="hidden" name="id" value="{{isset($detail) && !is_null($detail)?$detail->id:''}}">


                <div class="row">


                   <div class="col-md-4 form-group">
                    <label>City</label>
                    <select name="city" onchange="getHotel()" class="form-control" data-validation="required" id="city">
                        <option value="">Select</option>
                        @foreach($cities as $c)
                        <option value="{{$c->id}}" {{isset($detail) && !is_null($detail) && $detail->cities_id == $c->id?'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-8 form-group">
                    <label>Hotel Name</label>
                    <select id="hotel" class="form-control" name="hotel" data-validation="required">
                      
                      @if(isset($detail) && !is_null($detail) && !is_null($detail->hotel))
                      <option value="{{$detail->hotel->id}}">{{$detail->hotel->name}}</option>
                      @else
                      <option value="">Select City First</option>
                      @endif
                    </select>
                <!--     <input type="text" name="hotel_name" maxlength="200" data-validation="required" class="form-control" value="{{isset($detail) && !is_null($detail)?$detail->hotel_name:''}}" placeholder="Hotel Name"> -->

                </div>
              <!--   <div class="col-md-4 form-group">
                  <label>Hotel Star</label>
                  <select name="hotel_star" data-validation="required" class="form-control">
                      <option value=""  >Select</option>
                      <option value="economy"  {{isset($detail) && !is_null($detail) && $detail->hotel_star == 'economy'?'selected':''}}>Economy </option>
                      <option value="economy plus"  {{isset($detail) && !is_null($detail) && $detail->hotel_star == 'economy plus'?'selected':''}}>Economy Plus</option>
                      <option value="3"  {{isset($detail) && !is_null($detail) && $detail->hotel_star == '3'?'selected':''}}>3 Star</option>
                      <option value="4"  {{isset($detail) && !is_null($detail) && $detail->hotel_star == '4'?'selected':''}}>4 Star</option>
                      <option value="5"  {{isset($detail) && !is_null($detail) && $detail->hotel_star == '5'?'selected':''}}>5 Star</option>
                  </select>
              
              </div> -->
                <!-- <div class="col-md-6 form-group">
                    <label>Room Type</label>
                    <select name="room_type" data-validation="required" class="form-control">
                        <option value="">Select</option>
                        <option value="double"  {{isset($detail) && !is_null($detail) && $detail->room_type == 'double'?'selected':''}}>Double</option>
                        <option value="triple"  {{isset($detail) && !is_null($detail) && $detail->room_type == 'triple'?'selected':''}}>Triple</option>
                        <option value="quad"  {{isset($detail) && !is_null($detail) && $detail->room_type == 'quad'?'selected':''}}>Quad</option>
                        <option value="penta"  {{isset($detail) && !is_null($detail) && $detail->room_type == 'penta'?'selected':''}}>Penta</option>
                    </select>

                </div> -->
                <div class="col-md-4 form-group">
                    <label>Meal Type</label>
                    <select name="meal_type" data-validation="required" class="form-control">
                      <option value="">Select</option>
                        <option value="room only" {{isset($detail) && !is_null($detail) && $detail->meal_type == 'room only'?'selected':''}}>Room Only</option>
                        <option value="breakfast"  {{isset($detail) && !is_null($detail) && $detail->meal_type == 'breakfast'?'selected':''}}>Breakfast</option>
                        <option value="lunch"  {{isset($detail) && !is_null($detail) && $detail->meal_type == 'lunch'?'selected':''}}>Lunch</option>
                        <option value="dinner"  {{isset($detail) && !is_null($detail) && $detail->meal_type == 'dinner'?'selected':''}}>Dinner</option>
                    </select>

                </div>
                <div class="col-md-4  col-6 form-group">
                    <label>Price Valid From</label>
                    <input type="text" name="price_start" id="out_bound_date"  class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->price_start:''}}" placeholder="Start Date">

                </div>

                 <div class="col-md-4 col-6 form-group">
                    <label>Price Valid Till</label>
                    <input type="text" name="price_end" id="in_bound_date"  class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->price_end:''}}" placeholder="End Date">

                </div>
                <div class="col-md-4 col-4 form-group">
                    <label>Double</label>
                    <input type="number" name="double" pattern='[0-9]+(\\.[0-9][0-9]?)?' data-validation="length" data-validation-length="1-5" data-validation="required" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->double:''}}" placeholder="double">

                </div>
                <div class="col-md-4 col-4 form-group">
                    <label>Tripple </label>
                    <input type="number" name="tripple" pattern='[0-9]+(\\.[0-9][0-9]?)?' data-validation="length" data-validation-length="1-5" data-validation="required" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->tripple:''}}" placeholder="tripple">

                </div>
                <div class="col-md-4 col-4 form-group">
                    <label>Quad</label>
                    <input type="number" name="quad" pattern='[0-9]+(\\.[0-9][0-9]?)?' data-validation="length" data-validation-length="1-5" data-validation="required" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->quad:''}}" placeholder="quad">

                </div>

            <!--     <div class="col-md-6 form-group">
                <label>Saudi Agent Name</label>
                <input type="text" name="agent_name" data-validation="required" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->agent_name:''}}" placeholder="Agent Name">
            
            </div>
            <div class="col-md-6 form-group">
                <label>Saudi Agent Contact Number</label>
                <input type="text" name="agent_contact" class="form-control"  value="{{isset($detail) && !is_null($detail)?$detail->agent_contact:''}}" placeholder="Agent Number">
            
            </div> -->

            </div>


                <div class="row">
                    <div class="col-sm-6 col-sm-offset-5">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">

                        <!-- <input type="reset" value="Reset" class="btn btn-default"> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
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
       }).on('changeDate', function(selected){
           $('#out_bound_date').datepicker('setEndDate', $("#in_bound_date").val());
       }); 
    });
</script>
@endif
<script>
  function getHotel(){
    var city     = $('#city option:selected').val();
var SITE_PATH  = "{{url('/')}}";
    if(city.length){
      $.ajax({
        url: SITE_PATH+"/load-hotels",
        type:'get',
        data : {city: city},
        dataType: "JSON",
        beforeSend: function(){
          $('#hotel').html('<option>Loading..</option>');
        },
        success: function(data){
          $('#hotel').html(data.html);
        },
        error: function(){

        }
      });
    }else{
      $('#hotel').html('<option>Select City</option>');
    }
  }
$("#plan_id").change(function() {
    var plan = $('#plan_id option:selected').data('price');

    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#price').html('Total Price : <strong>' + price + '</strong>');
    $('#subs_price').val(price);
});
$("#period").change(function() {
    var plan = $('#plan_id option:selected').data('price');

    var period = $('#period option:selected').val();
    var price = plan * period;
    $('#subs_price').val(price);
    $('#price').html('Total Price : <strong>' + price + '</strong>');
});
</script>
@endpush