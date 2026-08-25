@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<style type="text/css">
/*   span.select2-selection {
    padding: 0px 5px 5px 5px !important;
    }*/
    .select2-container .select2-selection--multiple{
      min-height: 80px;
   }
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
      color: black;
   }
</style>
<div class="container">
   <section class="content-header">

      <ol class="breadcrumb">
         <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Generate Reservation</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-body">
            <form method="post" action="{{route('save-reservation')}}">
               {{csrf_field()}}

               <h1 class="text-center">
                Travel Reservation
             </h1>
             <hr>
             <div class="row">
               <div class="col-sm-8 col-md-offset-2">
                 <div class="row">
                   <div class="form-group col-md-2">
                     <label>Date From</label>
                     <input type="text" name="date_from" data-validation="required" class="form-control today-date" placeholder="Date From">
                  </div>
                  <div class="form-group col-md-2">
                     <label>Date To</label>
                     <input type="text" name="date_to" data-validation="required" class="form-control today-date" placeholder="Date To">
                  </div>
                  <div class="form-group col-md-4">
                     <label>Trip To</label>
                     <textarea name="trip_to" data-validation="required" class="form-control text-uppercase" rows="1" placeholder="Trip to "></textarea>
                  </div>
                  <div class="form-group col-md-2">
                     <label>Reservation Code</label>
                     <input type="text" name="code" data-validation="required" class="form-control text-uppercase" placeholder="code">
                  </div>
                  <div class="form-group col-md-2">
                     <label>Airline Code</label>
                     <input type="text" name="airline_res_code" data-validation="required" class="form-control text-uppercase" placeholder="code">
                  </div>
                    </div>
                    <div class="row">
                  <div class="col-sm-2 form-group" style="padding-right: 0">
                     <label class="control-label">Title</label>
                     <select name="gender" class="form-control" data-validation="required">
                      <option value="">Select</option>
                      <option value="MR">MR</option>
                      <option value="MRS">MRS</option>
                      <option value="MS">MS</option>
                      <option value="MISS">MISS</option>
                      <option value="MSTR">MSTR</option>
                      <option value="INFANT">INFANT</option>
                   </select>
                </div>
                  <div class="form-group col-md-4">
                     <label>Passenger Name</label>
                     <input type="text" name="passenger_name" data-validation="required" class="form-control text-uppercase" placeholder="Passenger">
                  </div>


               </div>
               <div class="" style="border: 1px solid #ddd;padding: 20px 10px;">
                  <div class="row form-group">
                     <div class="col-md-2 form-group">
                        <label>Departure Date</label>
                        <input type="text" name="departure_date[]" class="form-control ticket-date-mask">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Departure Time</label>
                        <input type="text" name="departure_time[]" class="form-control time">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Arrival Date</label>
                        <input type="text" name="arrival_date[]" class="form-control ticket-date-mask">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Arrival Time</label>
                        <input type="text" name="arrival_time[]" class="form-control time">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Ticket Number</label>
                        <input type="text" name="ticket_no[]" class="form-control text-uppercase">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Airline</label>
                        <input type="text" name="airline[]" class="form-control text-uppercase">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Departure City Code</label>
                        <input type="text" name="departure_city_code[]" class="form-control text-uppercase">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Departure City</label>
                        <input type="text" name="departure_city[]" class="form-control text-uppercase" placeholder="Departure city, Country ">
                     </div>

                     <div class="col-md-2 form-group">
                        <label>Arrival City Code</label>
                        <input type="text" name="arrival_city_code[]" class="form-control text-uppercase">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Arrival City</label>
                        <input type="text" name="arrival_city[]" class="form-control text-uppercase" placeholder="Arrival city, Country ">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Aircraft</label>
                        <input type="text" name="aircraft[]" class="form-control text-uppercase" placeholder="Aircraft">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Distance (in miles)</label>
                        <input type="text" name="distance[]" class="form-control" placeholder="distance">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Meals</label>
                        <input type="text" name="meals[]" class="form-control" placeholder="meals">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Departure Terminal</label>
                        <input type="text" name="departure_terminal[]" class="form-control" placeholder="terminal">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Arrival Terminal</label>
                        <input type="text" name="arrival_terminal[]" class="form-control" placeholder="terminal">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Duration</label>
                        <div class="row">
                           <div class="col-md-6">
                              <input type="text" name="duration_hours[]" class="form-control" placeholder="Hours">
                           </div>
                           <div class="col-md-6">
                              <input type="text" name="duration_minutes[]" class="form-control" placeholder="Minut">
                           </div>
                        </div>

                     </div>
                     <div class="col-md-2 form-group">
                        <label>Cabin</label>
                        <input type="text" name="cabin[]" class="form-control" placeholder="cabin">
                     </div>
                     <div class="col-md-2 form-group">
                        <label>Status</label>
                        <input type="text" name="status[]" class="form-control" placeholder="status">
                     </div>


                  </div>
                  <div class="more_fields"></div>
                  <div class="text-center">
                     <button type="button" class="btn btn-primary addmore " onclick="addmore(this)">More</button>
                  </div>
               </div>
               <br>
            </div>


         </div>
         <div class="text-center">
          <button type="submit" class="btn btn-primary">Generate</button>
       </div>
    </div>
 </form>
</div>
</div>
</section>
</div>
@endsection
@push('script')
<script type="text/javascript" src="https://d3a39i8rhcsf8w.cloudfront.net/js/jquery.mask.min.js"></script>
<script type="text/javascript">
   var count = 2;
   function addmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
      <div class="col-md-12">\
      <hr style="border-color:black">\
      </div>\
      <div class="col-md-2 form-group">\
                        <label>Departure Date</label>\
                        <input type="text" name="departure_date[]" class="form-control ticket-date-mask">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Departure Time</label>\
                        <input type="text" name="departure_time[]" class="form-control time">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Arrival Date</label>\
                        <input type="text" name="arrival_date[]" class="form-control ticket-date-mask">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Arrival Time</label>\
                        <input type="text" name="arrival_time[]" class="form-control time">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Ticket Number</label>\
                        <input type="text" name="ticket_no[]" class="form-control text-uppercase">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label class="btn-block">Airline <button class="btn btn-danger btn-sm pull-right" style="margin-top:-10px;" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\</label>\
                        <input type="text" name="airline[]" class="form-control text-uppercase">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Departure City Code</label>\
                        <input type="text" name="departure_city_code[]" class="form-control text-uppercase">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Departure City</label>\
                        <input type="text" name="departure_city[]" class="form-control text-uppercase" placeholder="Departure city, Country ">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Arrival City Code</label>\
                        <input type="text" name="arrival_city_code[]" class="form-control text-uppercase">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Arrival City</label>\
                        <input type="text" name="arrival_city[]" class="form-control text-uppercase" placeholder="Arrival city, Country ">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Aircraft</label>\
                        <input type="text" name="aircraft[]" class="form-control text-uppercase" placeholder="Aircraft">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Distance</label>\
                        <input type="text" name="distance[]" class="form-control" placeholder="distance">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Meals</label>\
                        <input type="text" name="meals[]" class="form-control" placeholder="meals">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Departure Terminal</label>\
                        <input type="text" name="departure_terminal[]" class="form-control" placeholder="terminal">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Arrival Terminal</label>\
                        <input type="text" name="arrival_terminal[]" class="form-control" placeholder="terminal">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Duration</label>\
                        <div class="row">\
                           <div class="col-md-6">\
                              <input type="text" name="duration_hours[]" class="form-control" placeholder="Hours">\
                           </div>\
                           <div class="col-md-6">\
                              <input type="text" name="duration_minutes[]" class="form-control" placeholder="Minut">\
                           </div>\
                        </div>\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Cabin</label>\
                        <input type="text" name="cabin[]" class="form-control" placeholder="cabin">\
                     </div>\
                     <div class="col-md-2 form-group">\
                        <label>Status</label>\
                        <input type="text" name="status[]" class="form-control" placeholder="status">\
                     </div>\
      </div>';
      count++;
      $('.more_fields').append(html);
      var maskBehavior = function (val) {
         val = val.split(":");
         return (parseInt(val[0]) > 19)? "HZ:M0" : "H0:M0";
      }

      spOptions = {
         onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
         },
         translation: {
            'H': { pattern: /[0-2]/, optional: false },
            'Z': { pattern: /[0-3]/, optional: false },
            'M': { pattern: /[0-5]/, optional: false}
         }
      };

      $('.time').mask(maskBehavior, spOptions);
      $('.numeric').numeric();
   }
   function remove(event) {
  /* var val = $(event).closest('.row');
   console.log(val);
    if (val != '') {
      var total = $('#total').val();
      total = parseInt(parseInt(total) - parseInt(val));
      $('#total').val(total);
   }*/
   $(event).closest('.row').remove();
   count--;
}
$(document).ready(function(){
       $(".ticket-date-mask").mask("99-99-9999");
   var maskBehavior = function (val) {
      val = val.split(":");
      return (parseInt(val[0]) > 19)? "HZ:M0" : "H0:M0";
   }

   spOptions = {
      onKeyPress: function(val, e, field, options) {
         field.mask(maskBehavior.apply({}, arguments), options);
      },
      translation: {
         'H': { pattern: /[0-2]/, optional: false },
         'Z': { pattern: /[0-3]/, optional: false },
         'M': { pattern: /[0-5]/, optional: false}
      }
   };

   $('.time').mask(maskBehavior, spOptions);
});
</script>
@endpush
