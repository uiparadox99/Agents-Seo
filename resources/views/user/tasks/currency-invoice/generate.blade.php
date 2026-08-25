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
         <li class="active">Generate Currency Invoice</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-body">
            <form method="post" action="{{route('save-currency-invoice')}}">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{isset($invoice) && !empty($invoice->id)?nl2br($invoice->id):''}}">
               <h1 class="text-center">
                 Generate Star Currency Invoice
              </h1>
              <hr>
              <div class="row">
               <div class="col-sm-8 col-md-offset-2">
                <div class="row">
                  <div class=" col-md-4">
                     <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" data-validation="required" class="form-control" placeholder="Customer Name" value="{{isset($ticket) && !empty($ticket['customer_name'])?$ticket['customer_name']:''}}">
                     </div>
                     <div class="form-group">
                        <label>Customer Phone</label>
                        <input type="text" name="customer_phone" data-validation="required" class="form-control" placeholder="Customer Phone" value="{{isset($ticket) && !empty($ticket['customer_phone'])?$ticket['customer_phone']:''}}">
                     </div>
                     <div class="form-group">
                        <label>Customer ID Number</label>
                        <input type="text" name="customer_id_num" class="form-control" placeholder="Customer ID Number" value="{{isset($ticket) && !empty($ticket['customer_id_num'])?$ticket['customer_id_num']:''}}">
                     </div>
                     <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="text" name="dob" class="form-control today-date" placeholder="dob" value="{{isset($ticket) && !empty($ticket['dob'])?$ticket['dob']:''}}">
                     </div>
                  </div>
                  <div class="form-group col-md-4">
                    <h2 class="text-center">Invoice</h2>
                 </div>
                 <div class="form-group col-md-4">
                    <div class="form-group">
                     <label>Date</label>
                     <input type="text" name="date" data-validation="required" class="form-control today-date" placeholder="date" value="{{isset($ticket) && !empty($ticket['date'])?$ticket['date']:''}}">
                  </div>
                  <div class="form-group">
                     <label>Invoice No</label>
                     <input type="text" name="ref" data-validation="required" class="form-control" placeholder="No" value="{{isset($ticket) && !empty($ticket['ref'])?$ticket['ref']:''}}">
                  </div>

               </div>
            </div>
           
            <div class="" style="border: 1px solid #ddd;padding: 20px 10px;margin-bottom:20px">
              <div class="row">
                <div class="col-md-4 form-group">
                  <label>Currency Received</label>
                  <input type="text" name="c_received" class="form-control" placeholder="Currency Received"  value="{{isset($ticket) && !empty($ticket['c_received'])?$ticket['c_received']:''}}">
                </div>
                <div class="col-md-4 form-group">
                  <label>Currency Received Amount (Digits)</label>
                  <input type="text" name="c_received_amount_digit" class="form-control" placeholder="Currency Received Amount"  value="{{isset($ticket) && !empty($ticket['c_received_amount_digit'])?$ticket['c_received_amount_digit']:''}}">
                </div>
                <div class="col-md-4 form-group">
                  <label>Currency Received Amount (Words)</label>
                  <input type="text" name="c_received_amount_words" class="form-control" placeholder="Currency Received Amount Words"  value="{{isset($ticket) && !empty($ticket['c_received_amount_words'])?$ticket['c_received_amount_words']:''}}">
                </div>
              </div>
            </div>
            <div class="" style="border: 1px solid #ddd;padding: 20px 10px;">
              <div class="row">
               <div class="col-md-4 form-group">
                 <label>Currency Paid</label>
                 <input type="text" name="c_paid" class="form-control" placeholder="Currency Paid"  value="{{isset($ticket) && !empty($ticket['c_paid'])?$ticket['c_paid']:''}}">
               </div>
               <div class="col-md-4 form-group">
                 <label>Currency Paid Amount (Digits)</label>
                 <input type="text" name="c_paid_amount_digit" class="form-control" placeholder="Currency Paid Amount"  value="{{isset($ticket) && !empty($ticket['c_paid_amount_digit'])?$ticket['c_paid_amount_digit']:''}}">
               </div>
               <div class="col-md-4 form-group">
                 <label>Currency Paid Amount (Words)</label>
                 <input type="text" name="c_paid_amount_words" class="form-control" placeholder="Currency Paid Amount Words"  value="{{isset($ticket) && !empty($ticket['c_paid_amount_words'])?$ticket['c_paid_amount_words']:''}}">
               </div>
             </div>
            </div>
        <br>
            {{-- <div class="form-group">
               <label>Remarks</label>
               <textarea name="remarks" class="form-control" id=""  rows="5">{!! isset($ticket) && isset($ticket['remarks'])?str_replace('<br />','',$ticket['remarks']):'Star Holidays UK Ltd
Account No: 13928705
Sort Code:    20-90-69
Bank:             Barclays'!!}</textarea>
            </div> --}}
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
<script type="text/javascript">
   var count = '{{isset($ticket) && !empty($ticket["sr_no"])?$key+2:"2"}}';
   function addmore(event) {
      var html = ' <div class="row field_'+count+' form-group">\
      <div class="col-md-1">\
      <label>Sr NO.</label>\
      <input type="text" name="sr_no[]" class="form-control" placeholder="No" value="'+count+'">\
      </div>\
      <div class="col-md-3">\
      <label>Name</label>\
      <input type="text" name="name[]" class="form-control">\
      </div>\
      <div class="col-md-2">\
      <label>Ticket Number</label>\
      <input type="text" name="ticket_no[]" class="form-control">\
      </div>\
      <div class="col-md-3">\
      <label>Sector</label>\
      <input type="text" name="sector[]" class="form-control">\
      </div>\
      <div class="col-md-2">\
      <label>Amount</label>\
      <input type="text" name="amount[]"  maxlength="5"  onchange="addamount(this)" class="form-control numeric amount_field">\
      </div>\
      <div class="col-md-1">\
      <label>&nbsp;</label>\
      <button class="btn btn-danger  btn-block" type="button" onclick="remove(this)"><i class="fa fa-trash"></i></button>\
      </div>\
      </div>';
      count++;
      $('.more_fields').append(html);
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
