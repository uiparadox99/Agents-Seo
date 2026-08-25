   @php
   $id             = isset($tickets)?$tickets->id:'';
   $report_date    = isset($tickets)?date('d-m-Y',strtotime($tickets->report_date)):(request()->has('report_date')?request()->get('report_date'):'');
   $pax_name       = isset($tickets)?$tickets->pax_name:(request()->has('pax_name')?request()->get('pax_name'):'');
   $ticket_no      = isset($tickets)?$tickets->ticket_no:'';
   $sector         = isset($tickets)?$tickets->sector:(request()->has('sector')?request()->get('sector'):'');
   $phone          = isset($tickets)?$tickets->phone:(request()->has('phone')?request()->get('phone'):'');
   $passport          = isset($tickets)?$tickets->passport:'';
   $fare           = isset($tickets)?number_format($tickets->trans->fare,2):(request()->has('fare')?request()->get('fare'):'');
   $tax            = isset($tickets)?number_format($tickets->trans->tax,2):(request()->has('tax')?request()->get('tax'):0);
   $tax2            = isset($tickets)?number_format($tickets->trans->tax2,2):(request()->has('tax2')?request()->get('tax2'):0);
   $tax3            = isset($tickets)?number_format($tickets->trans->tax3,2):(request()->has('tax3')?request()->get('tax3'):0);
   $tax4            = isset($tickets)?number_format($tickets->trans->tax4,2):(request()->has('tax4')?request()->get('tax4'):0);
   $cost           = isset($tickets)?number_format($tickets->trans->cost,2):(request()->has('cost')?request()->get('cost'):'');
   $sale           = isset($tickets)?number_format($tickets->trans->sale,2):(request()->has('sale')?request()->get('sale'):'');
   $profit         = isset($tickets)?number_format($tickets->trans->profit,2):(request()->has('profit')?request()->get('profit'):'');
   $admins_id      = isset($tickets)?$tickets->agents_id:auth()->user()->id;
   $parties_id     = isset($tickets)?$tickets->parties_id:(request()->has('parties_id')?request()->get('parties_id'):'');
   $suppliers_id   = isset($tickets)?$tickets->suppliers_id:(request()->has('suppliers_id')?request()->get('suppliers_id'):'');
   $flights_id     = isset($tickets)?$tickets->flights_id:(request()->has('flights_id')?request()->get('flights_id'):'');
   $flights_id_2     = isset($tickets)?$tickets->flights_id_2:(request()->has('flights_id_2')?request()->get('flights_id_2'):'');
   $flights_id_3     = isset($tickets)?$tickets->flights_id_3:(request()->has('flights_id_3')?request()->get('flights_id_3'):'');
   $flights_id_4     = isset($tickets)?$tickets->flights_id_4:(request()->has('flights_id_4')?request()->get('flights_id_4'):'');
   $gds     = isset($tickets)?$tickets->gds:(request()->has('gds')?request()->get('gds'):'');
   $airline_pnr     = isset($tickets)?$tickets->airline_pnr:(request()->has('airline_pnr')?request()->get('airline_pnr'):'');
   $travel_date     = isset($tickets) && !empty($tickets->travel_date)?date('d-M-Y',strtotime($tickets->travel_date)):(request()->has('travel_date')?request()->get('travel_date'):'');
   $travel_date_2     = isset($tickets) && !empty($tickets->travel_date_2)?date('d-M-Y',strtotime($tickets->travel_date_2)):(request()->has('travel_date_2')?request()->get('travel_date_2'):'');
   $travel_date_3     = isset($tickets) && !empty($tickets->travel_date_3)?date('d-M-Y',strtotime($tickets->travel_date_3)):(request()->has('travel_date_3')?request()->get('travel_date_3'):'');
   $travel_date_4     = isset($tickets) && !empty($tickets->travel_date_4)?date('d-M-Y',strtotime($tickets->travel_date_4)):(request()->has('travel_date_4')?request()->get('travel_date_4'):'');
   $airline_id     = isset($tickets)?$tickets->airlines_id:(request()->has('airline')?request()->get('airline'):'');
   $title     = isset($tickets)?$tickets->title:'';
   $surname     = isset($tickets)?$tickets->surname:'';
   $given_name     = isset($tickets)?$tickets->given_name:'';
   $dob     = isset($tickets) && !empty($tickets->dob)?date('d/m/yy',strtotime($tickets->dob)):'';
  
@endphp

<form action="{{ route('save-ticket') }}" method="POST" enctype="multipart/form-data">
 {{ csrf_field() }}
 <input type="hidden" name="id" value="{{ $id }}">
 <div class="row">
  <div class="col-md-6" style="    border-right: 5px solid #757575dd;">
    <div class="row">
      <div class="col-sm-6 form-group">
       <label class="control-label">Report Date</label>
       <input placeholder="Date" class="form-control ticket-date-mask" type="text" value="{{ $report_date }}" name="report_date">
     </div>
     <div class="col-sm-6 form-group">
       <div class="row">
         <div class="col-sm-12 ">
           <label class="control-label">Invoices Number</label>
           <input placeholder="Invoice Number" data-validation="required" class="form-control"  name="" type="text" value="{{ !empty($id)?$id:$new_invoice_no }}"  disabled="">
         </div>
       </div>
     </div>
   </div>

   <div class="row">
     <div class="col-sm-6 form-group">
       <label class="control-label">Ticket Number</label>
       <input placeholder="Ticket Number" data-validation-error-msg="Only Digit" class="form-control" id="ticket_no" name="ticket_no" type="text" value="{{ $ticket_no }}" data-validation="number" onkeyup="nextIndex(this, 13, 'input[name=sector]')">
     </div>

     <div class="col-sm-6 form-group">
       <label class="control-label">Sector</label>
       <input placeholder="Sector" class="form-control text-uppercase autocomplete sector"  name="sector" type="text" value="{{ $sector }}" data-validation="required" onkeyup="nextIndex(this, 15, 'input[name=pax_name]')">
       <ul class="typeahead dropdown-menu" role="listbox" style="top: 59px; left: 15px; display: none;">
        <li onclick="addsector('LHR-ISB-LHR')"><a href="javascript:;">LHR-ISB-LHR</a></li>
        <li onclick="addsector('LHR-LHE-LHR')"><a href="javascript:;">LHR-LHE-LHR</a></li>
        <li onclick="addsector('LHR-KHI-LHR')"><a href="javascript:;">LHR-KHI-LHR</a></li>
        <li onclick="addsector('MAN-ISB-MAN')"><a href="javascript:;">MAN-ISB-MAN</a></li>
        <li onclick="addsector('MAN-LHE-MAN')"><a href="javascript:;">MAN-LHE-MAN</a></li>
        <li onclick="addsector('BHX-ISB-BHX')"><a href="javascript:;">BHX-ISB-BHX</a></li>
      </ul>
     </div>
   </div>

   <div class="row">
     <div class="col-sm-2 form-group" style="padding-right: 0">
      <label class="control-label">Title</label>
      <select name="title" class="form-control" data-validation="required">
        <option value="">Select</option>
        <option value="MR" {{$title == 'MR'?'selected':''}}>MR</option>
        <option value="MRS" {{$title == 'MRS'?'selected':''}}>MRS</option>
        <option value="MS" {{$title == 'MS'?'selected':''}}>MS</option>
        <option value="MISS" {{$title == 'MISS'?'selected':''}}>MISS</option>
        <option value="MSTR" {{$title == 'MSTR'?'selected':''}}>MSTR</option>
        <option value="INFANT" {{$title == 'INFANT'?'selected':''}}>INFANT</option>
      </select>
    </div>
    <div class="col-sm-4 form-group">
     <label class="control-label require">Surname</label>
     <input placeholder="Surname" class="form-control onlyLetters" name="surname" type="text" value="{{ $surname??'' }}" data-validation="required">
   </div>

   <div class="col-sm-6 form-group">
     <label class="control-label require">Given name</label>
     <input placeholder="Given Name" class="form-control onlyLetters" name="given_name" type="text" value="{{ $given_name??'' }}" data-validation="required">
   </div>
 </div>
 <div class="row">
   <div class="col-sm-6 form-group">
     <label class="control-label require">Party &nbsp; <a href="javascript:;" class="partyDetailButton" style="display: none;" onclick="opendModal(this)" data-toggle="modal" data-target="#myModal" style="text-decoration: underline;">Party Detail</a></label>
     <select name="parties_id" id="party" class="form-control select2" onchange="showDetailButton(this)" data-validation="required">
      <option value="" data-passengers="">Select Party</option>
      @foreach($parties as $p)
      <option value="{{ $p->id }}" data-passengers="{{json_encode($p->passengers)}}" data-phone="{{ $p->phone }}" {{ $parties_id == $p->id?'selected':'' }}>
        {{ $p->name }}
      </option>
      @endforeach
    </select>
  </div>

  <div class="col-sm-3 form-group" style="padding-right: 8px;">
   <label class="control-label require">Phone</label>
   <input placeholder="Phone" class="form-control numeric"  maxlength="14" name="phone" type="text" value="{{ $phone }}" data-validation="number" data-validation-error-msg="Only Digit">
 </div>
 <div class="col-sm-3 form-group" style="padding-left: 8px;">
  <label class="control-label require">Passport</label>
  <input type="text" name="passport" class="form-control text-uppercase " placeholder="Passport" value="{{$passport}}" maxlength="15" data-validation="required" data-validation-error-msg="Required">
</div> 
</div>
<div class="row">

  <div class="col-sm-3 form-group" style="padding-right: 8px;">
   <label class="control-label require">Airline PNR</label>
   <input placeholder="PNR" class="form-control text-uppercase"  maxlength="6" name="airline_pnr" type="text" value="{{ $airline_pnr }}" data-validation="required" data-validation-error-msg="Required">
 </div>
 <div class="col-sm-3 form-group" style="padding-left: 8px;">
  <label class="control-label ">GDS</label>
  <input type="text" name="gds" class="form-control text-uppercase" placeholder="GDS" value="{{$gds}}" maxlength="6" >
</div>

<div class="col-sm-6 form-group">

<label class="control-label require">Date of Birth</label>
<input type="text" name="dob" class="form-control dob"  value="{{isset($dob)?$dob:''}}" placeholder="Date">
 <!-- <div class="row">
  <div class="col-sm-12" >
    <label class="control-label require">Date of Birth</label>
  </div>
  <div class="col-md-3" style="padding-right: 0;" >
    <input type="number" class="form-control" min="1" max="31" name="day" value="{{isset($day)?$day:''}}" placeholder="Day">
 
  </div>
  <div class="col-md-5" style="padding-left: 5px;padding-right: 5px;">
    <select name="month" id="month" class="form-control">
 
      <option value="Jan"  {{isset($month) && $month == 'Jan'?'selected':''}}> January </option>
      <option value="Feb" {{isset($month) && $month == 'Feb'?'selected':''}}> February </option>
      <option value="Mar" {{isset($month) && $month == 'Mar'?'selected':''}}> March </option>
      <option value="Apr" {{isset($month) && $month == 'Apr'?'selected':''}}> April </option>
      <option value="May" {{isset($month) && $month == 'May'?'selected':''}}> May </option>
      <option value="Jun" {{isset($month) && $month == 'Jun'?'selected':''}}> June </option>
      <option value="Jul" {{isset($month) && $month == 'Jul'?'selected':''}}> July </option>
      <option value="Aug" {{isset($month) && $month == 'Aug'?'selected':''}}> August </option>
      <option value="Sep" {{isset($month) && $month == 'Sep'?'selected':''}}> September </option>
      <option value="Oct" {{isset($month) && $month == 'Oct'?'selected':''}}> October </option>
      <option value="Nov" {{isset($month) && $month == 'Nov'?'selected':''}}> November </option>
      <option value="Dec" {{isset($month) && $month == 'Dec'?'selected':''}}> December </option>
    </select>
  </div>
 
  <div class="col-md-4" style="padding-left: 0;">
    <input type="number" class="form-control" minlength="4" maxlength="4" name="year" value="{{isset($year)?$year:''}}" placeholder="year">
 
  </div>
 </div> -->
</div>
</div>
</div>
<div class=col-md-6>
 <div class="row">

  <div class="col-sm-6 form-group">
   <label class="control-label require">Supplier</label>
   <select name="suppliers_id" class="form-control select2" data-validation="required" data-validation-error-msg="Required"> 
    <option value="">Select Supplier</option>
    @foreach($suppliers as $s)
    <option value="{{ $s->id }}" {{ $suppliers_id == $s->id?'selected':'' }}>
      {{ $s->name }}
    </option>
    @endforeach
  </select>
</div>
<div class="col-sm-6 form-group">
 <label class="control-label require">Airlines</label>
 <select name="airline" id="airlines" class="form-control " data-validation="required" data-validation-error-msg="Required">
  <option value="">Select Airline</option>
  @foreach($airlines as $a)
  <option value="{{ $a->id }}" data-code="{{$a->code}}" {{ $airline_id == $a->id?'selected':'' }}>
    {{ $a->name }}
  </option>
  @endforeach
</select>
</div>

<div class="col-sm-12 ">
 <div class="row">


   <div class="col-sm-2 form-group">
     <label class="control-label require">Fare</label>
     <input placeholder="Fare" class="form-control" name="fare" type="number" step=".01" value="{{ $fare }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" data-validation-error-msg="Only Digit" onkeyup="calcTax(this)" min="0">
   </div>

   <div class="col-sm-2 form-group">
     <label class="control-label require">Tax 1</label>
     <input placeholder="Tax" class="form-control" name="tax" type="number" step=".01" value="{{ $tax }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" data-validation-error-msg="Only Digit" onkeyup="calcTax(this)" min="0" >

   </div>
   <div class="col-sm-2 form-group">
     <label class="control-label require">Tax 2</label>
     <input placeholder="Tax" class="form-control" name="tax2" type="number" step=".01" value="{{ $tax2 }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" data-validation-error-msg="Only Digit" onkeyup="calcTax(this)" min="0" >

   </div>
   <div class="col-sm-2 form-group">
     <label class="control-label require">Tax 3</label>
     <input placeholder="Tax" class="form-control" name="tax3" type="number" step=".01" value="{{ $tax3 }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" data-validation-error-msg="Only Digit" onkeyup="calcTax(this)" min="0" >

   </div>
   <div class="col-sm-2 form-group">
     <label class="control-label require">Tax 4</label>
     <input placeholder="Tax" class="form-control" name="tax4" type="number" step=".01" value="{{ $tax4 }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" data-validation-error-msg="Only Digit" onkeyup="calcTax(this)" min="0" >

   </div>

   <div class="col-sm-2 form-group">
     <label class="control-label require">Total Cost</label>
     <input placeholder="Cost" class="form-control" id="ticketCost" name="cost" type="text" value="{{ $cost }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)" readonly="">
   </div>
 </div>
</div>
<div class="col-sm-6 form-group">
 <label class="control-label require">Sale Price</label>
 <input placeholder="Sale Price" id="ticketSale" class="form-control" name="sale" step=".01" type="number" min="0" value="{{ $sale }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)">
</div>

<div class="col-sm-6 form-group">
 <label class="control-label require">Profit</label>
 <input placeholder="Profit" class="form-control" id="ticketProfit" name="profit" type="text" value="{{ $profit }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)" readonly="">
</div>
</div>
<div class="row">
  <div class="col-sm-3 form-group">
    <label class="control-label require">Flight</label>
    <input type="text" class="form-control flight text-uppercase" name="flights_id" value="{{ $flights_id }}" data-validation="required" data-validation-error-msg="Required" placeholder="Sector">

  </div>
  <div class="col-sm-3 form-group">
    <label class="control-label require">Travel Date</label>
    <input type="text" name="travel_date" data-validation="required" class="form-control today-date" placeholder="Date" value="{{$travel_date}}" data-validation-error-msg="Required">
  </div>
  <div class="col-sm-3 form-group">
    <label class="control-label ">Flight</label>
    <input type="text" class="form-control flight text-uppercase" name="flights_id_2" value="{{ $flights_id_2 }}" placeholder="Sector">

  </div>
  <div class="col-sm-3 form-group">
    <label class="control-label ">Travel Date</label>
    <input type="text" name="travel_date_2" class="form-control today-date" placeholder="Date" value="{{$travel_date_2}}">
  </div>
</div>
<div class="row">
  <div class="col-sm-3 form-group">
    <label class="control-label ">Flight</label>
    <input type="text" class="form-control flight text-uppercase" name="flights_id_3" value="{{ $flights_id_3 }}" placeholder="Sector">
    
  </div>
  <div class="col-sm-3 form-group">
    <label class="control-label require">Travel Date</label>
    <input type="text" name="travel_date_3" class="form-control today-date" placeholder="Date" value="{{$travel_date_3}}">
  </div>
  <div class="col-sm-3 form-group">
    <label class="control-label ">Flight</label>
    <input type="text" class="form-control flight text-uppercase" name="flights_id_4" value="{{ $flights_id_4 }}" placeholder="Sector">
  </div>
  <div class="col-sm-3">
    <label class="control-label require">Travel Date</label>
    <input type="text" name="travel_date_4" class="form-control today-date" value="{{$travel_date_4}}" placeholder="Date">
  </div>
</div>
</div>
</div>

<div class="form-group text-right" >
<label><input type="checkbox" name="copy_form" value="1" style="width: 20px;height: 20px;">&nbsp;&nbsp; <span style="font-size: 20px;font-weight: normal;">Copy Form Data?</span></label>
</div>
<div class="form-group">

  <button type="reset" class="btn btn-info">Reset</button>
  <button class="btn btn-primary btn-flat pull-right" type="submit">Submit</button>   
</div>
</form>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Party Detail</h4>
      </div>
      <div class="modal-body">
        <ul id="passengersList">
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <!--    <div class="col-sm-6 form-group">
      <label class="control-label">Status</label>
      <select name="status" class="form-control">
       @foreach($Ticektstatuses  as $s)
       <option value="{{$s->id}}">{{$s->name}}</option>
       @endforeach
     </select>
   </div> -->