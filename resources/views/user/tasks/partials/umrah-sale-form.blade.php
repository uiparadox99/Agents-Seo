<form action="{{ route('save-umrah-sale') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ isset($detail) && !empty($detail) ? $detail->id:'' }}">

    <div class="row">
        <div class="col-sm-6 form-group">
            <label class="control-label">Report Date</label>
            <input placeholder="Date" class="form-control today-date" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->report_date:'' }}" name="report_date">
        </div>

        <div class="col-sm-6 form-group">
            <label class="">Passengers name</label>
            <input placeholder="Passengers Name" class="form-control onlyLetters" name="passenger_name" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->passenger_name:'' }}" data-validation="required">
        </div>
    </div>
    <div class="row">
      <div class="col-sm-3 form-group">
        <label class="">Party</label>
        <select name="parties_id" id="party" class="form-control select2" data-validation="required">
          <option value="">Select Party</option>
          @foreach($parties as $p)
          <option value="{{ $p->id }}" data-phone="{{ $p->phone }}" {{ isset($detail) && !empty($detail) && $detail->parties_id == $p->id?'selected':'' }}> {{ $p->name }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="col-sm-3 form-group">
        <label class="">Phone</label>
        <input placeholder="Phone" class="form-control " maxlength="14" name="phone" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->phone:'' }}" data-validation="number" data-validation-error-msg="Only Digit">
      </div>
      <div class="col-sm-6 form-group">
        <label class="">Supplier</label>
        <select name="suppliers_id" class="form-control select2" data-validation="required" data-validation-error-msg="Required">
          <option value="">Select Supplier</option>
          @foreach($suppliers as $s)
          <option value="{{ $s->id }}" {{ isset($detail) && !empty($detail) && $detail->suppliers_id == $s->id?'selected':'' }}> {{ $s->name }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row">    

   
     
  <div class="col-sm-3 form-group">
        <label class="">Days</label>
        <input placeholder="Days" class="form-control "  name="days" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->days:'' }}" data-validation="number" data-validation-error-msg="Only Digit">
      </div>
       <div class="col-sm-3 form-group">
        <label style="width: 100%;">&nbsp;</label>
        <label class="">Only Visa
        <input placeholder="Days" class=" "  name="only_visa" type="checkbox" value="1" {{ isset($detail) && !empty($detail) &&  $detail->only_visa == 1 ?'checked':'' }}> </label>
      </div>
        
     
        

        <div class="col-sm-2 form-group">
            <label class="">Total Cost</label>
            <input placeholder="Cost" class="form-control" id="umrahCost" name="cost" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->cost:'' }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)">
        </div>

        <div class="col-sm-2 form-group">
            <label class="">Sale Price</label>
            <input placeholder="Sale Price" class="form-control" id="umrahSale" name="sale" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->sale:'' }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)">
        </div>

        <div class="col-sm-2 form-group">
            <label class="">Profit</label>
            <input placeholder="Profit" class="form-control" id="umrahProfit" name="profit" type="text" value="{{ isset($detail) && !empty($detail) ? $detail->profit:'' }}" data-validation="custom" data-validation-regexp="[+-]?([0-9]*[.])?[0-9]+" maxlength="4" data-validation-error-msg="Only Digit" onkeyup="limNum(this)">
        </div>
               </div>
    <div class="row">
      
     
        <div class="col-sm-12 form-group">
            <label class="">Remarks</label>
            <textarea placeholder="Remarks" class="form-control  " name="remarks">{{ isset($detail) && !empty($detail) ? $detail->remarks:'' }}</textarea>
        </div>

    </div>

    <div class="form-group">

        <button type="reset" class="btn btn-info">Reset</button>
        <button class="btn btn-primary btn-flat pull-right" type="submit">Submit</button>
    </div>
</form>