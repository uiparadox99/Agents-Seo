@extends('layouts.master')
@section('taskHeader')
 @include('includes/tasks-header')
@endsection
@section('content')
<div class="container">
   
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Add Party</h3>
            <div class="box-tools pull-right">
            </div>
         </div>
         <div class="box-body">
            <div class="row">
                       
               <div class="col-md-12">
                  <form action="{{ route('save-party') }}" method="POST" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <input type="hidden" value="{{ isset($party)?$party->id:'' }}" name="id">
                        <div class="row">
                          <div class="col-sm-12 form-group">
                            <label class="control-label require">
                              <input name="task_Add" type="radio" onclick="checkDetail(this)" value="no" checked=""> &nbsp;&nbsp; Party Only</label> &nbsp; &nbsp; &nbsp;
                               <label class="control-label require">
                              <input name="task_Add" type="radio" onclick="checkDetail(this)" value="yes"> &nbsp;&nbsp; Party With Task</label>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label class="control-label require">Category</label>
                                <select name="category" id="category" class="form-control" data-validation="required">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{isset($party) && $party->account_categories_id == $c->id?'selected':($c->id == '4'?'selected':'')}}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="type" value="party">

                           <div class="col-sm-4 form-group">
                              <label class="control-label require">Name</label>
                              <input placeholder="Name" class="form-control" name="name" type="text" value="{{ old('name', isset($party)?$party->name:'') }}" data-validation="required" >
                           </div>
                            <div class="col-sm-4 form-group">
                              <label class="control-label require">Email</label>
                              <input placeholder="Email" class="form-control" name="email" type="text" value="{{ old('email', isset($party)?$party->email:'') }}">
                           </div>
                         </div>
                         <div class="row">
                            <div class="col-sm-4 form-group">
                              <label class="control-label require">Phone</label>
                              <input placeholder="Phone" class="form-control" maxlength="14" name="phone" pattern="\d*" type="text" value="{{ old('phone', isset($party)?$party->phone:'') }}" data-validation="required" oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                           </div>
                           <div class="col-sm-4 form-group">
                              <label class="control-label require">Phone 2</label>
                              <input placeholder="Phone" class="form-control" maxlength="14" name="phone_2" pattern="\d*" type="text" value="{{ old('phone_2', isset($party)?$party->phone_2:'') }}"  oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                           </div>
                       </div>
                          <div class="row">
                             <div class="col-sm-4 form-group">
                              <label class="control-label require">Phone 3</label>
                              <input placeholder="Phone" class="form-control" maxlength="14" name="phone_3" pattern="\d*" type="text" value="{{ old('phone_3', isset($party)?$party->phone_3:'') }}"  oninvalid="this.setCustomValidity('Invalid Phone Number')" oninput="setCustomValidity('')">
                           </div>
                           <div class="col-sm-4 form-group ">
                            <label>Sector</label>
                            <select name="party_sector" class="form-control">
                               <option value="">Select</option>
                               @foreach ($sectors as $s)
                                  <option value="{{$s->name}}" {{isset($party) && $party->sector == $s->name?'selected':''}}>{{$s->name}}</option>
                               @endforeach
                            </select>
                            {{-- <input type="text" name="party_sector" class="form-control" value="{{ old('sector', isset($party)?$party->sector:'') }}" placeholder="Sector"> --}}
                           </div>
                           <div class="col-sm-4 form-group ">
                              <label>Second Sector</label>
                              <select name="sector_two" class="form-control">
                                 <option value="">Select</option>
                                 @foreach ($sectors as $s)
                                    <option value="{{$s->name}}" {{isset($party) && $party->sector_two == $s->name?'selected':''}}>{{$s->name}}</option>
                                 @endforeach
                              </select>
                              {{-- <input type="text" name="sector_two" class="form-control" value="{{ old('sector', isset($party)?$party->sector_two:'') }}" placeholder="second sector"> --}}
                             </div>
                          
                           <div class="col-sm-12 form-group task-info" style="display: none;">
                             <label>Remarks</label>
                             <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', isset($party)?$party->remarks:'') }}</textarea>
                           </div>
                           <div class="col-sm-12 form-group">
                            <label class="control-label require">
                              <input name="is_show_in_accounts" {{ old('is_show_in_accounts', isset($party)?$party->is_show_in_accounts:'') == 1?'checked':'' }} type="checkbox" value="1" checked > &nbsp;&nbsp; Show in Accounts</label>
                            </div>
                            
                          </div>
                           

                          <div class="form-group">
                            
                            <button type="reset" class="btn btn-info btn-flat">Reset</button>
                            <button class="btn btn-primary btn-flat pull-right" type="submit">Submit</button>                     
                            
                          </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
  function checkDetail(e) {
      var val = $("input[name='task_Add']:checked").val();
      if (val == 'yes') {
        $('.task-info').show();
      }else{
        $('.task-info').hide();
      }
  }
</script>
@endpush
