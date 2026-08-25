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
         <li class="active">Generate Voucher</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-body">
            <form method="post" action="{{route('save-travel-invoice')}}">
               {{csrf_field()}}

               <h1 class="text-center">
                 Generate Voucher
              </h1>
              <hr>
                <div class="row">
                 
              
                 <div class="form-group col-md-7" >
                    <div class="row">
                        
                   
                    <div class="form-group  col-md-4">
                     <label>Voucher Date</label>
                     <input type="text" name="date" data-validation="required" class="form-control dateMasking" placeholder="date">
                  </div>
                  <div class="form-group  col-md-4">
                     <label>Voucher No</label>
                     <input type="text" name="ref" data-validation="required" class="form-control" placeholder="No">
                  </div>
                  <div class="form-group  col-md-4">
                    <label>Package</label>
                    <input type="text" name="package" data-validation="required" class="form-control" placeholder="package">
                 </div>
                 <div class="form-group  col-md-4">
                    <label>Pax</label>
                    <input type="text" name="main_pax"  class="form-control" placeholder="pax no">
                 </div>
                 <div class="form-group  col-md-4">
                    <label>Manual No</label>
                    <input type="text" name="manual" class="form-control" placeholder="manual no">
                 </div>
                 <div class="form-group  col-md-4">
                    <label>Family Head</label>
                    <input type="text" name="family_head" data-validation="required" class="form-control alpha" maxlength="35" placeholder="family head">
                 </div>
                </div>

               </div>
               <div class="form-group col-md-5" style="border-left:1px solid;">
                <div class="form-group">
                    <label>Travel Agency Name</label>
                    <input type="text" name="agency_name" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Agency Intro or Address</label>
                            <input type="text" name="agency_address" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Agency city</label>
                            <input type="text" name="agency_city" class="form-control">
                        </div>
                    </div>
                </div>
                
               
                
             </div>
            </div>
            <div class="" style="border: 1px solid #ddd;padding:0px 10px 20px 10px;">
                <h3 class="text-center"><b>Mutamers</b></h3>
               <div class="row form-group">
                  <div class="col-sm-1">
                     <label>Sr NO.</label>
                     <input type="text" name="sr_no[]" class="form-control" placeholder="No" value="1">
                  </div>
            
                  <div class="col-sm-3">
                    <label>Name</label>
                    <input type="text" name="name[]" class="form-control">
                 </div>
                 <div class="col-sm-1" style="padding-left: 0">
                    <label>Passport</label>
                    <input type="text" name="passport[]" class="form-control">
                 </div>
                  <div class="col-sm-1">
                     <label>Pax</label>
                     <select  name="pax[]" class="form-control">
                        <option value="Adult">Adult</option>
                        <option value="Child">Child</option>
                        <option value="Infant">Infant</option>
                     </select>
                  </div>
                  <div class="col-sm-1">
                    <label>Bed</label>
                    <input type="text" name="bed[]" class="form-control">
                 </div>
                 <div class="col-md-1">
                    <label>Aitekaf</label>
                    <input type="text" name="aitekaf[]" class="form-control">
                 </div>
                 <div class="col-md-1">
                    <label>Group no</label>
                    <input type="text" name="group_no[]" class="form-control">
                 </div>
                  <div class="col-md-1">
                     <label>Visa #</label>
                     <input type="text" name="visa[]" class="form-control">
                  </div>
                  <div class="col-md-1">
                    <label>PNR</label>
                    <input type="text" name="pnr[]" class="form-control">
                 </div>
                  <div class="col-md-1">
                     <label>&nbsp;</label>
                     <button type="button" class="btn btn-primary addmore btn-block" onclick="addmore(this)">More</button>
                  </div>
               </div>
               <div class="more_fields"></div>
            </div>
            <br>
            <br>
            <div class="" style="border: 1px solid #ddd;padding:0px 10px 20px 10px;">
                <h3 class="text-center"><b>Accommodation</b></h3>
               <div class="row form-group">
                  <div class="col-sm-2">
                     <label>City</label>
                     <input type="text" name="city[]" class="form-control" placeholder="city" value="">
                  </div>
                  <div class="col-sm-3" style="padding-left: 0">
                     <label>Hotel Name</label>
                     <input type="text" name="hotel_name[]" class="form-control">
                  </div>
                  <div class="col-sm-1">
                    <label>BRN</label>
                    <input type="text" name="acc_brn[]" class="form-control">
                 </div>
                  <div class="col-sm-1">
                     <label>Confirm</label>
                     <input type="text" name="confirm[]" class="form-control">
                  </div>
                  <div class="col-sm-1">
                    <label>Room Type</label>
                    <input type="text" name="room_type[]" class="form-control">
                 </div>
                 <div class="col-md-1">
                    <label>Checkin</label>
                    <input type="text" name="checkin[]" class="form-control dateMasking">
                 </div>
                 <div class="col-md-1">
                    <label>Checkout</label>
                    <input type="text" name="checkout[]" class="form-control dateMasking">
                 </div>
                  <div class="col-md-1">
                     <label>Nights</label>
                     <input type="text" name="nights[]"  maxlength="5" onchange="addamount(this)"   class="form-control numeric">
                  </div>
                  <div class="col-md-1">
                     <label>&nbsp;</label>
                     <button type="button" class="btn btn-primary addmore btn-block" onclick="addaccmore(this)">More</button>
                  </div>
               </div>
               <div class="more_acc_fields"></div>
               <div class="text-right">
                <b>Total Night:</b> <input type="text" name="total_nights"  class=" numeric" id="total" placeholder="total">
               </div>
            </div>
            <br>
            <br>
            <div class="" style="border: 1px solid #ddd;padding:0px 10px 20px 10px;">
                <h3 class="text-center"><b>Transport/Services</b></h3>
               <div class="row form-group">
                  <div class="col-sm-3">
                     <label>Transporter</label>
                     <input type="text" name="transporter[]" class="form-control" placeholder="transporter" value="">
                  </div>
                  <div class="col-sm-2" style="padding-left: 0">
                     <label>Type</label>
                     <input type="text" name="type[]" class="form-control">
                  </div>
                  <div class="col-sm-4">
                    <label>Description</label>
                    <input type="text" name="trans_description[]" class="form-control">
                 </div>
                  <div class="col-sm-2">
                     <label>BRN</label>
                     <input type="text" name="brn[]" class="form-control">
                  </div>
                  <div class="col-md-1">
                     <label>&nbsp;</label>
                     <button type="button" class="btn btn-primary addmore btn-block" onclick="addtransmore(this)">More</button>
                  </div>
               </div>
               <div class="more_trans_fields"></div>
               
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="" style="border: 1px solid #ddd;padding:0px 10px 20px 10px;">
                        <h3 class="text-center"><b>Departure</b></h3>
                        <div class="form-group">
                        <label>Deprature Title - Like:  Departure (Pakistan to KSA)</label>
                        <input name="departure_title" class="form-control" value="">
                    </div>
                       <div class="row form-group">
                          <div class="col-sm-2">
                             <label>Flight</label>
                             <input type="text" name="dep_flight[]" class="form-control" placeholder="flight" value="">
                          </div>
                          <div class="col-sm-2" style="padding-left: 0">
                             <label>Sectore</label>
                             <input type="text" name="dep_sector[]" class="form-control sector">
                          </div>
                          <div class="col-sm-3">
                            <label>Departure</label>
                            <input type="text" name="dep_datetime[]" class="form-control datetime">
                         </div>
                         <div class="col-sm-3">
                            <label>Arrival</label>
                            <input type="text" name="dep_arrival_datetime[]" class="form-control datetime">
                         </div>
                          <div class="col-md-2">
                             <label>&nbsp;</label>
                             <button type="button" class="btn btn-primary addmore btn-block" onclick="adddepmore(this)">More</button>
                          </div>
                       </div>
                       <div class="more_dep_fields"></div>
                       
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="" style="border: 1px solid #ddd;padding:0px 10px 20px 10px;">
                        <h3 class="text-center"><b>Arrival</b></h3>
                        <div class="form-group">
                        <label>Arrival Title - Like:  Arrival (KSA to Pakistan)</label>
                        <input name="arrival_title" class="form-control" value="">
                    </div>
                       <div class="row form-group">
                          <div class="col-sm-2">
                             <label>Flight</label>
                             <input type="text" name="arr_flight[]" class="form-control" placeholder="flight" value="">
                          </div>
                          <div class="col-sm-2" style="padding-left: 0">
                             <label>Sectore</label>
                             <input type="text" name="arr_sector[]" class="form-control sector">
                          </div>
                          <div class="col-sm-3">
                            <label>Departure</label>
                            <input type="text" name="arr_datetime[]" class="form-control datetime">
                         </div>
                         <div class="col-sm-3">
                            <label>Arrival</label>
                            <input type="text" name="arr_arrival_datetime[]" class="form-control datetime">
                         </div>
                          <div class="col-md-2">
                             <label>&nbsp;</label>
                             <button type="button" class="btn btn-primary addmore btn-block" onclick="addarrmore(this)">More</button>
                          </div>
                       </div>
                       <div class="more_arr_fields"></div>
                       
                    </div>
                </div>
            </div>
            <br>
            <br>
            {{-- <div class="col-md-2">
                <label>Nights</label>
                <input type="text" name="amount[]"  maxlength="5" onchange="addamount(this)"  class="form-control numeric">
             </div> --}}
            <div class="row">
               <div class="form-group col-md-3">
                  <label>Special Instructions</label>
                  <input type="text" name="special_instruction" class="form-control" placeholder="Instructions">
               </div>
               <div class="form-group col-md-3">
                  <label>Makkah Contact</label>
                  <input type="text" name="makkah_contact" class="form-control" placeholder="contact">
               </div>
               <div class="form-group col-md-3">
                <label>Makkah Contact</label>
                <input type="text" name="makkah_contact_two" class="form-control" placeholder="contact">
             </div>
             <div class="form-group col-md-3">
                <label>Madina Transport Basma Contact</label>
                <input type="text" name="madina_basma" class="form-control" placeholder="contact">
             </div>
            </div>
            <hr>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Generate Voucher</button>
     </div>
  </div>
</form>
</div>
</div>
</section>
</div>
@endsection
@push('script')
<script type="text/javascript">
 $(document).ready(function(){
    $('.dateMasking').mask('99-99-9999')
    $('.sector').mask('aaa-aaa')
    $('.alpha').alpha()
    $('.datetime').mask('99-aaa 99:99')
 })
   var count = 2;
   function addmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
        <div class="col-sm-1">\
                     <label>Sr NO.</label>\
                     <input type="text" name="sr_no[]" class="form-control" placeholder="No" value="'+count+'">\
                  </div>\
                  <div class="col-sm-3">\
                    <label>Name</label>\
                    <input type="text" name="name[]" class="form-control">\
                 </div>\
                 <div class="col-sm-1" style="padding-left: 0">\
                     <label>Passport</label>\
                     <input type="text" name="passport[]" class="form-control">\
                  </div>\
                  <div class="col-sm-1">\
                     <label>Pax</label>\
                     <select  name="pax[]" class="form-control">\
                        <option value="Adult">Adult</option>\
                        <option value="Child">Child</option>\
                        <option value="Infant">Infant</option>\
                     </select>\
                  </div>\
                  <div class="col-sm-1">\
                    <label>Bed</label>\
                    <input type="text" name="bed[]" class="form-control">\
                 </div>\
                 <div class="col-md-1">\
                    <label>Aitekaf</label>\
                    <input type="text" name="aitekaf[]" class="form-control">\
                 </div>\
                 <div class="col-md-1">\
                    <label>Group no</label>\
                    <input type="text" name="group_no[]" class="form-control">\
                 </div>\
                  <div class="col-md-1">\
                     <label>Visa #</label>\
                     <input type="text" name="visa[]" class="form-control">\
                  </div>\
                  <div class="col-md-1">\
                    <label>PNR</label>\
                    <input type="text" name="pnr[]" class="form-control">\
                 </div>\
      <div class="col-md-1">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_fields').append(html);
      $('.numeric').numeric();
      $('.dateMasking').mask('99-99-9999')
      $('.sector').mask('aaa-aaa')
   }
   function remove(event) {
   $(event).closest('.row').remove();
   count--;
}
function addaccmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
        <div class="col-sm-2">\
                     <label>City</label>\
                     <input type="text" name="city[]" class="form-control" placeholder="city" value="">\
                  </div>\
                  <div class="col-sm-3" style="padding-left: 0">\
                     <label>Hotel Name</label>\
                     <input type="text" name="hotel_name[]" class="form-control">\
                  </div>\
                  <div class="col-sm-1">\
                    <label>BRN</label>\
                    <input type="text" name="acc_brn[]" class="form-control">\
                 </div>\
                  <div class="col-sm-1">\
                     <label>Confirm</label>\
                     <input type="text" name="confirm[]" class="form-control">\
                  </div>\
                  <div class="col-sm-1">\
                    <label>Room Type</label>\
                    <input type="text" name="room_type[]" class="form-control">\
                 </div>\
                 <div class="col-md-1">\
                    <label>Checkin</label>\
                    <input type="text" name="checkin[]" class="form-control dateMasking">\
                 </div>\
                 <div class="col-md-1">\
                    <label>Checkout</label>\
                    <input type="text" name="checkout[]" class="form-control dateMasking">\
                 </div>\
                  <div class="col-md-1">\
                     <label>Nights</label>\
                     <input type="text" name="nights[]"  maxlength="5" onchange="addamount(this)"   class="form-control numeric">\
                  </div>\
      <div class="col-md-1">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_acc_fields').append(html);
      $('.numeric').numeric();
      $('.dateMasking').mask('99-99-9999')
      $('.sector').mask('aaa-aaa')
   }
   function addtransmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
        <div class="col-sm-3">\
                     <label>Transporter</label>\
                     <input type="text" name="transporter[]" class="form-control" placeholder="transporter" value="">\
                  </div>\
                  <div class="col-sm-2" style="padding-left: 0">\
                     <label>Type</label>\
                     <input type="text" name="type[]" class="form-control">\
                  </div>\
                  <div class="col-sm-4">\
                    <label>Description</label>\
                    <input type="text" name="trans_description[]" class="form-control">\
                 </div>\
                  <div class="col-sm-2">\
                     <label>BRN</label>\
                     <input type="text" name="brn[]" class="form-control">\
                  </div>\
      <div class="col-md-1">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_trans_fields').append(html);
      $('.numeric').numeric();
      $('.dateMasking').mask('99-99-9999')
      $('.sector').mask('aaa-aaa')
   }
   function adddepmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
        <div class="col-sm-2">\
                             <label>Flight</label>\
                             <input type="text" name="dep_flight[]" class="form-control" placeholder="flight" value="">\
                          </div>\
                          <div class="col-sm-2" style="padding-left: 0">\
                             <label>Sectore</label>\
                             <input type="text" name="dep_sector[]" class="form-control sector">\
                          </div>\
                          <div class="col-sm-3">\
                            <label>Departure</label>\
                            <input type="text" name="dep_datetime[]" class="form-control datetime">\
                         </div>\
                         <div class="col-sm-3">\
                            <label>Arrival</label>\
                            <input type="text" name="dep_arrival_datetime[]" class="form-control datetime">\
                         </div>\
      <div class="col-md-2">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_dep_fields').append(html);
      $('.numeric').numeric();
      $('.dateMasking').mask('99-99-9999')
      $('.datetime').mask('99-aaa 99:99')
      $('.sector').mask('aaa-aaa')
   }
   function addarrmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
        <div class="col-sm-2">\
                             <label>Flight</label>\
                             <input type="text" name="arr_flight[]" class="form-control" placeholder="flight" value="">\
                          </div>\
                          <div class="col-sm-2" style="padding-left: 0">\
                             <label>Sectore</label>\
                             <input type="text" name="arr_sector[]" class="form-control sector">\
                          </div>\
                          <div class="col-sm-3">\
                            <label>Departure</label>\
                            <input type="text" name="arr_datetime[]" class="form-control datetime">\
                         </div>\
                         <div class="col-sm-3">\
                            <label>Arrival</label>\
                            <input type="text" name="arr_arrival_datetime[]" class="form-control datetime">\
                         </div>\
      <div class="col-md-2">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_arr_fields').append(html);
      $('.numeric').numeric();
      $('.dateMasking').mask('99-99-9999')
      $('.datetime').mask('99-aaa 99:99')
      $('.sector').mask('aaa-aaa')
   }
function addamount(event) {
   var val = $(event).val();
   var total = $('#total').val();
   if (total != '') {
    total = parseInt(parseInt(val) + parseInt(total));
 }else{
   total = parseInt(val);
}
$('#total').val(total);
}
</script>
@endpush
