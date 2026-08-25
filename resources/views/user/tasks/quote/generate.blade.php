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
         <li class="active">Generate Quotation</li>
      </ol>
   </section>
   <section class="content">
      <div class="box">
         <div class="box-body">
            <form method="post" action="{{route('save-quotation')}}">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{isset($invoice) && !empty($invoice->id)?$invoice->id:''}}">
               <h1 class="text-center">
                 Generate Quotation
              </h1>
              <hr>
              <div class="row">
               <div class="col-sm-8 col-md-offset-2">
                <div class="row">
                  <div class="form-group col-md-4">
                     <label>Party</label>
                     <textarea name="party" data-validation="required" class="form-control" rows="5">{!! isset($ticket) && !empty($ticket['party'])?$ticket['party']:'' !!}</textarea>
                  </div>
                  <div class="form-group col-md-4">
                    <h2 class="text-center">Quotation</h2>
                 </div>
                 <div class="form-group col-md-4">
                    <div class="form-group">
                     <label>Date</label>
                     <input type="text" name="date" data-validation="required" class="form-control today-date" placeholder="date" value="{{isset($ticket) && !empty($ticket['date'])?$ticket['date']:''}}">
                  </div>

               </div>
            </div>
           
            <div class="" style="border: 1px solid #ddd;padding: 20px 10px;">
               @if(isset($ticket) && !empty($ticket['sr_no']))
               @foreach ($ticket['sr_no'] as $key => $sr_no)
                  <div class="row form-group">
                     <div class="col-md-1">
                        <label>Sr NO.</label>
                        <input type="text" name="sr_no[]" class="form-control" placeholder="No" value="{{$key+1}}">
                     </div>
                     <div class="col-md-3">
                        <label>Name</label>
                        <input type="text" name="name[]" class="form-control" value="{{isset($ticket['name'])?$ticket['name'][$key]:''}}">
                     </div>
                     <div class="col-md-2">
                        <label>Type</label>
                        <input type="text" name="type[]" class="form-control" value="{{isset($ticket['type'])?$ticket['type'][$key]:''}}">
                     </div>
                     <div class="col-md-3">
                        <label>Sector</label>
                        <input type="text" name="sector[]" class="form-control" value="{{isset($ticket['sector'])?$ticket['sector'][$key]:''}}">
                     </div>
                     <div class="col-md-2">
                        <label>Amount</label>
                        <input type="text" name="amount[]" value="{{isset($ticket['amount'])?$ticket['amount'][$key]:''}}"  maxlength="5" onchange="addamount(this)"  class="form-control numeric">
                     </div>
                     <div class="col-md-1">
                        <label>&nbsp;</label>
                        @if(count($ticket['sr_no']) == $key+1)
                        <button type="button" class="btn btn-primary addmore btn-block" onclick="addmore(this)">More</button>
                        @endif
                     </div>
                  </div>
               @endforeach
               @else
               <div class="row form-group">
                  <div class="col-md-1">
                     <label>Sr NO.</label>
                     <input type="text" name="sr_no[]" class="form-control" placeholder="No" value="1">
                  </div>
                  <div class="col-md-3">
                     <label>Name</label>
                     <input type="text" name="name[]" class="form-control">
                  </div>
                  <div class="col-md-2">
                     <label>Type</label>
                     <input type="text" name="type[]" class="form-control">
                  </div>
                  <div class="col-md-3">
                     <label>Sector</label>
                     <input type="text" name="sector[]" class="form-control">
                  </div>
                  <div class="col-md-2">
                     <label>Amount</label>
                     <input type="text" name="amount[]"  maxlength="5" onchange="addamount(this)"  class="form-control numeric">
                  </div>
                  <div class="col-md-1">
                     <label>&nbsp;</label>
                     <button type="button" class="btn btn-primary addmore btn-block" onclick="addmore(this)">More</button>
                  </div>
               </div>
               @endif
               <div class="more_fields"></div>
            </div>
        
            <br>
            <br>
            <div class="row">
               <div class="form-group col-md-4">
                  <label>Payment Recieved (GBP)</label>
                  <input type="text" name="recieved" class="form-control" placeholder="recieved"  value="{{isset($ticket) && !empty($ticket['recieved'])?$ticket['recieved']:''}}">
               </div>
               <div class="form-group col-md-4">
                  <label>Balance</label>
                  <input type="text" name="balance" class="form-control" placeholder="balance"  value="{{isset($ticket) && !empty($ticket['balance'])?$ticket['balance']:''}}">
               </div>
               <div class="form-group col-md-4">
                  <label>Total</label>
                  <input type="text" name="total" data-validation="required"  value="{{isset($ticket) && !empty($ticket['total'])?$ticket['total']:''}}" class="form-control numeric" id="total" placeholder="total">
               </div>
               <div class="form-group col-md-6">
                  <label>Remarks</label>
                  <textarea name="remarks" class="form-control" id=""  rows="5">{!! isset($ticket) && isset($ticket['remarks'])?str_replace('<br />','',$ticket['remarks']):'Star Holidays UK Ltd
Account No: 13928705
Sort Code:    20-90-69
Bank:             Barclays'!!}</textarea>
            </div>
            <div class="form-group col-md-6">
               <label>Flight Remarks</label>
               <textarea name="flight_remarks" class="form-control" id=""  rows="5">{!! isset($ticket) && isset($ticket['flight_remarks'])?str_replace('<br />','',$ticket['flight_remarks']):''!!}</textarea>
         </div>
         </div>
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
      <label>Type</label>\
      <input type="text" name="type[]" class="form-control">\
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
